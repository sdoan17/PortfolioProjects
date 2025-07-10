# Open Air Quality Data Pipeline

This project builds a beginner-friendly data pipeline that collects, processes, and visualizes real-time air quality data using OpenAQ’s public S3 archive. It strikes a balance between approachability for newcomers and practical exposure to key data engineering concepts.

- 🔗 **OpenAQ S3 Archive**: [Documentation](https://docs.openaq.org/aws/about)  

---

## 🎯 Objectives
1. **Tech Stack**  
   - **Python**: For scripting, automation, and dashboard development (using Plotly Dash).  
   - **DuckDB**: A fast, embedded analytics database serving as the data warehouse.

2. **End Product**  
   - A complete pipeline that dynamically extracts, processes, and displays air quality data.

---

## 🗂️ Project Layout

- `notebooks/`: For experiments and prototyping.  
- `sql/`: DuckDB SQL scripts for ETL operations.  
- `pipeline/`: CLI-based tools for extraction, transformation, and DB setup.  
- `dashboard/`: The Plotly Dash app for live data visualization.  
- `locations.json`: Contains location-specific sensor metadata.  
- `secrets-example.json`: Template for API credentials (do not commit actual secrets).  
- `requirements.txt`: Python package dependencies.

---

## 🗃️ Database Design

DuckDB is structured into schemas:

- **raw schema**  
  - Stores all raw ingested air quality records.

- **presentation schema**  
  - `air_quality`: The most recent valid reading per sensor and parameter.  
  - `daily_air_quality_stats`: Daily averages per parameter and location.  
  - `latest_param_values_per_location`: Snapshot of the latest values at each site.

---

## 🚀 How to Run the Project

### 1. Set Up Your Environment
```bash
$ python -m venv .venv
$ source .venv/bin/activate  # or .\.venv\Scripts\activate on Windows
$ pip install -r requirements.txt
```

### 2. Initialize the Database
```bash
$ cd pipeline
$ python database_manager.py --create
```

### 3. Run Extraction
```bash
$ python extraction.py [args]
```

### 4. Run Transformations
```bash
$ python transformation.py
```

### 5. Launch the Dashboard
```bash
$ cd dashboard
$ python app.py
```

Visit the dashboard in your browser. The DuckDB file will be created and updated locally.

---

