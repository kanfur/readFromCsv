# CSV Reader and Importer With a Queuing System

This is a PHP project that reads data from a CSV file, 
applies some filters, and then imports the data into an 
SQLite database table. It includes a web interface that 
allows users to upload CSV files and view the imported data.

File has big data, so I wrote a queuing system with job to 
read these lines. A container named queue_worker stands up 
and processes the process from the queue in the database 
when the file is uploaded. When you refresh the datalist page, 
you will see that the total number has changed. 
The job will remain open until you have read and saved all 
the lines.

During the save process, I used the updateOrCreate method,
so even though there are more than 100000 lines in the file 
it will save up to 97976 lines

## Requirements

- PHP >= 8.0
- Composer
- Docker >= 19.03
- Docker Compose >= 1.25

## Installation

1. Clone the repository:

   `git clone https://github.com/kanfur/readFromCsv.git`
2. Install dependencies:

   `composer install`
3. Start the Docker containers:

   `docker-compose up -d --build`
4. Access the web interface at http://localhost:8000.

## Usage

### Uploading a CSV file

1. Click on the "Upload From File" button on the homepage.
2. Select a CSV file to upload.
3. Click on the "File Import" button to import the data into the database.

### Filtering the data

1. On the "Dataset" page, select the desired filters from the dropdown menus.
2. Click on the "Filter" button to apply the selected filters.
3. Click on the "Clear Filters" button to clear all filters.

### Viewing the data

The "Dataset" page displays a table of imported data with the following columns:

- Category
- Gender
- Birth Date
- Age
- Age Range

This project was created by **H. Furkan Ozturk** and is licensed under the MIT license.
