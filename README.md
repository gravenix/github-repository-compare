# Setup
To launch this application you just need to type `make start` in the CLI and voila, you have launched the docker containers.

# Usage 
In order to compare repositories you have to perform `GET` request at `http://localhost:8000/github/repository/compare`. Like this:
```http
GET http://localhost:8000/github/repository/compare?repositories[]=githubtraining/hellogitworld&repositories[]=githubtraining/github-slideshow-demo
Content-Type: application/json
```