# Setup
To launch this application you just need to type `make start` in the CLI and voila, you have launched the docker containers.

# Usage 
In order to compare repositories you have to perform `GET` request at `http://localhost:8000/github/repository/compare`. Like this:
```http
GET http://localhost:8000/github/repository/compare?repositories[]=githubtraining/hellogitworld&repositories[]=shopware/platform
Content-Type: application/json
```

# Make commands
 - `make start` starts docker container
 - `make stop` stops container
 - `make clean` removes containers
 - `make ssh` connects to container ssh
 - `make phpunit` runs unit tests

# Additional Information
This is not finished but I'm running out of time I'm able to spend on this, a few comments/todos is left.