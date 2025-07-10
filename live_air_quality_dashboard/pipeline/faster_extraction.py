import argparse
import json
import logging
from datetime import datetime
from dateutil.relativedelta import relativedelta
from typing import List

from duckdb import IOException
from jinja2 import Template

from database_manager import (
    connect_to_database,
    close_database_connection,
    execute_query,
    read_query
)

def read_location_ids(file_path: str) -> List[str]:
    with open(file_path, "r") as f:
        locations = json.load(f)
    return [str(id) for id in locations.keys()]

def compile_data_file_paths(base_path: str, location_ids: List[str], start_date: str, end_date: str) -> List[str]:
    start_date = datetime.strptime(start_date, "%Y-%m")
    end_date = datetime.strptime(end_date, "%Y-%m")
    paths = []
    index_date = start_date
    while index_date <= end_date:
        year = str(index_date.year)
        month = str(index_date.month).zfill(2)
        for loc in location_ids:
            paths.append(f"{base_path}/locationid={loc}/year={year}/month={month}/*.csv.gz")
        index_date += relativedelta(months=1)
    return paths

def batch_insert_query(paths: List[str], extract_query_template: str) -> str:
    data_file_path = ",\n    ".join(paths)
    return Template(extract_query_template).render(data_file_path=data_file_path)

def extract_data(args):
    location_ids = read_location_ids(args.locations_file_path)
    data_paths = compile_data_file_paths(args.source_base_path, location_ids, args.start_date, args.end_date)
    extract_template = read_query(args.extract_query_template_path)
    con = connect_to_database(args.database_path)

    # Set parallelism
    con.sql("SET threads TO 4;")

    # Batch by month
    batches = {}
    for path in data_paths:
        month_key = "/".join(path.split("/")[-4:-1])  # locationid=.../year=YYYY/month=MM
        batches.setdefault(month_key, []).append(path)

    for month_key, path_group in batches.items():
        logging.info(f"Extracting batch for {month_key} with {len(path_group)} files")
        try:
            query = batch_insert_query(path_group, extract_template)
            execute_query(con, query)
            logging.info(f"Inserted batch for {month_key}.")
        except IOException as e:
            logging.warning(f"Failed to extract {month_key}: {e}")

    close_database_connection(con)

def main():
    logging.basicConfig(level=logging.INFO, format="%(levelname)s:%(name)s:%(message)s")
    parser = argparse.ArgumentParser(description="Optimized CLI for ELT Extraction")
    parser.add_argument("--locations_file_path", type=str, required=True)
    parser.add_argument("--start_date", type=str, required=True)
    parser.add_argument("--end_date", type=str, required=True)
    parser.add_argument("--extract_query_template_path", type=str, required=True)
    parser.add_argument("--database_path", type=str, required=True)
    parser.add_argument("--source_base_path", type=str, required=True)
    args = parser.parse_args()
    extract_data(args)

if __name__ == "__main__":
    main()
