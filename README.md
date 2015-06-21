# Simple RESTful PHP API

Simple PHP script that adds a very basic API to a MySQL InnoDB database.

## Requirements
  * PHP 5.4 or newer
  * MySQL
  * PDO

## Usage
The API consists of the following methods:

| URL | HTTP Method | Description |
| --- |:-----------:| :-----------|
| /jobs/list | GET | Return an array of jobs. |
| /jobs/{id} | GET | Return the job with an ID of `id`. |
| /jobs/{id} | PUT | Update the job with an ID of `id`. |
| /jobs/{id} | DELETE | Deletes the job with an ID of `id`. |
| /candidates/list | GET | Return an array of all candidates. |
| /candidates/review/{id} | GET | Return the candidate with an ID of `id`. |
| /candidates/review/{id} | DELETE | Deletes the candidate with an ID of `id`. |
| /candidates/search/{id} | GET | Search for candidate with an ID of `id`. |


