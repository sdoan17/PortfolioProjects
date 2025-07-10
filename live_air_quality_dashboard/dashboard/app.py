import dash
from dash import dcc, html, Input, Output
import plotly.express as px
import duckdb as ddb
import pandas as pd

app = dash.Dash(__name__)

# def line_figure():
#     line_fig = px.line(
#         daily_stats_df[daily_stats_df["parameter"] == 'o3'].sort_values(by ="measurement_date"),
#         x = "measurement_date",
#         y = "average_value",
#         title = "Plot Over Time of o3 Levels"
#     )
#     return line_fig

# def box_figure():
#     box_fig = px.box(
#         daily_stats_df[daily_stats_df["parameter"] == 'o3'].sort_values(by ="weekday_number"),
#         x = "weekday",
#         y = "average_value",
#         title = "Distribution of o3 Levels by Weekday"
#     )
#     return box_fig
app.layout = html.Div([
      dcc.Tabs([
            dcc.Tab(
                  label="Sensor Locations",
                  children=[dcc.Graph(id="map-view")]
            ),
            dcc.Tab(
                  label="Parameter Plots",
                  children=[
                        dcc.Dropdown(
                              id="location-dropdown",
                              clearable=False,
                              multi=False,
                              searchable=True
                        ),
                        dcc.Dropdown(
                              id="parameter-dropdown",
                              clearable=False,
                              multi=False,
                              searchable=True
                        ),
                        dcc.DatePickerRange(
                              id="date-picker-range",
                              display_format="YYYY-MM-DD"
                        ),
                        dcc.Graph(id="line-plot"),
                        dcc.Graph(id="box-plot")
                  ]
            )
      ])
])

@app.callback(
      Output("map-view", "figure"),
      Input("map-view", "id")
)

def update_map(_):
    with ddb.connect("../air_quality.db", read_only=True) as db_connection:
        latest_values_df = db_connection.execute(
            "SELECT * FROM presentation.latest_param_values_per_location"
        ).fetchdf()

    latest_values_df.fillna(0, inplace=True)
    map_fig = px.scatter_map(
        latest_values_df,
        lat = "lat",
        lon = "lon",
        hover_name = "location",
        hover_data= {
            "lat": False,
            "lon": False,
            "datetime" : True,
            "o3": True, 
            "no2": True, 
            'pm25': True,
            'pm10': True,
            'so2': True
        },
        zoom =6.0
    )
    map_fig.update_layout(
        mapbox_style = "open-street-map",
        height = 800,
        title = "Air Quality Monitoring Locations"
    )
    return map_fig

@app.callback(
    [
        Output("location-dropdown", "options"),
        Output("location-dropdown", "value"),
        Output("parameter-dropdown", "options"),
        Output("parameter-dropdown", "value"),
        Output("date-picker-range", "start_date"),
        Output("date-picker-range", "end_date"),
    ],
    Input("location-dropdown", "id"),
)

def update_dropdowns(_):
    with ddb.connect("../air_quality.db", read_only=True) as db_connection:
        df = db_connection.execute(
            "SELECT * FROM presentation.daily_air_quality_stats"
        ).fetchdf()

    location_options = [
        {"label": location, "value": location} for location in df["location"].unique()
    ]
    parameter_options = [
        {"label": parameter, "value": parameter}
        for parameter in df["parameter"].unique()
    ]
    start_date = df["measurement_date"].min()
    end_date = df["measurement_date"].max()

    return (
        location_options,
        df["location"].unique()[0],
        parameter_options,
        df["parameter"].unique()[0],
        start_date,
        end_date,
    )

@app.callback(
        [Output("line-plot", "figure"), Output("box-plot", 'figure')],
        [
            Input("location-dropdown", "value"),
            Input("parameter-dropdown", "value"),
            Input("date-picker-range", "start_date"),
            Input("date-picker-range", "end_date")
        ]
)

def update_plot(selected_location, selected_parameter, start_date, end_date):
    with ddb.connect("../air_quality.db", read_only=True) as db_connection:
        daily_stats_df = db_connection.execute(
            "SELECT * FROM presentation.daily_air_quality_stats"
        ).fetchdf()

    filtered_df = daily_stats_df[daily_stats_df.location == selected_location]
    filtered_df = filtered_df[filtered_df.parameter == selected_parameter]
    filtered_df = filtered_df[
        (filtered_df.measurement_date >= pd.to_datetime(start_date))
        & (filtered_df.measurement_date <= pd.to_datetime(end_date))
    ]

    # If there's no data, return empty plots
    if filtered_df.empty:
        return px.line(title="No data available"), px.box(title="No data available")

    labels = {
        "average_value" : filtered_df.units.unique()[0],
        "measurement_date" : "Date"
    }

    line_fig = px.line(
        filtered_df.sort_values(by="measurement_date"),
        x="measurement_date",
        y="average_value",
        labels=labels,
        title=f"Plot Over Time of {selected_parameter} Levels"
    )

    box_fig = px.box(
        filtered_df.sort_values(by="weekday_number"),
        x="weekday",
        y="average_value",
        labels=labels,
        title=f"Distribution of {selected_parameter} Levels by Weekday"
    )

    return line_fig, box_fig

if __name__ == "__main__":
    app.run(debug=True)