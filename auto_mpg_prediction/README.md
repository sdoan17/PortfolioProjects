# Practical Linear Regression

## Dataset

The [automobile miles per gallon (auto-mpg)](https://archive.ics.uci.edu/dataset/9/auto+mpg) dataset, initially made available through the statlib library, comes in a .data format — a legacy fixed-width structure with no embedded column names or data types. Additionally, the UCI repository doesn't specify the original measurement units. However, based on contextual clues like the use of 'miles' and 'gallons', it's reasonable to assume the data follows the imperial system. After some investigation, a rough mapping of the feature values and units was inferred.

| Variable     | Description                                                                                                                                                      | Unit                  |
|-------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------|
| displacement | Engine displacement is the measure of the cylinder volume swept by all of the pistons of a piston engine, excluding the combustion chambers.                    | cubic inches         |
| mpg         | The number of miles that a vehicle can travel on 1 gallon of fuel, assuming no load. This dataset quotes 'city-cycle' mpg which is a measure for driving in urban areas.                                                                             | miles/gallon         |
| cylinders   | The number of cylinders in a vehicle's engine. Cylinders comprise a piston and two valves (inflow and outflow) and are located within the engine.                | integer              |
| horsepower  | A unit of measurement of power, or the rate at which work is done, usually in reference to the output of engines or motors.                                      | hp (imperial)        |
| weight      | The relative mass of the vehicle.                                                                                                                                | pounds               |
| acceleration| The time taken for a vehicle to cover a quarter of a mile from an idle state.                                                                                   | seconds           |
| model_year  | The year in which the vehicle model was produced.                                                                                                               | years (e.g., 70 = 1970) |

## Predicted Horsepower Results

The following car models are missing values for horsepower in the dataset.

| Car Name                 | Model Year | Cylinders | Predicted Horsepower | Actual Horsepower | Source |
|--------------------------|------------|-----------|----------------------|-------------------|------------------------------------------------------------------------------------------------|
| Ford Pinto               | 1971       | 4         | 74.1                 | 75                | [Auto Evoution](https://www.autoevolution.com/cars/ford-pinto-1971.html#aeng_ford-pinto-1971-16) |
| Ford Maverick            | 1974       | 6         | 94.2                | 82                | [Vega Dataset (GitHub)](https://github.com/vega/vega/blob/main/docs/data/cars.json) |
| Renault LeCar Deluxe     | 1980       | 4         | 60.4                 | 55                | [Vega Dataset (GitHub)](https://github.com/vega/vega/blob/main/docs/data/cars.json) |
| Ford Mustang Cobra       | 1980       | 4         | 95.3                 | 88                | [Vega Dataset (GitHub)](https://github.com/vega/vega/blob/main/docs/data/cars.json) |
| Renault 18i              | 1981       | 4         | 73.6                 | 81                | [Vega Dataset (GitHub)](https://github.com/vega/vega/blob/main/docs/data/cars.json) |
| AMC Concord DL           | 1982       | 4         | 76.2                 | 110                | [Wikipedia](https://en.wikipedia.org/wiki/AMC_Concord) |

## Future Work & Improvements
- Feature Engineering Enhancements
Incorporate additional features such as vehicle type (e.g., sedan, SUV), transmission type, or manufacturer to improve predictive accuracy and better capture horsepower variance across models.

- Non-linear Models & Ensemble Techniques
Explore more advanced regression models like polynomial regression, decision trees, or ensemble methods (e.g., Random Forest, Gradient Boosting) to capture non-linear relationships and reduce prediction error.

- Unit Normalization & Data Scaling
Standardize or normalize features such as weight, displacement, and acceleration to ensure fair contribution in distance-based models or when expanding to more complex algorithms.

- Deployment Potential
Wrap the model in a simple web app (e.g., with Streamlit or Flask) to allow users to input car specs and receive estimated horsepower predictions dynamically.