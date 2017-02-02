### Setup Using Docker

Docker setup definitions:
- github_repo_link: [insert repo link]
- local_folder_name: We recommend you create a folder *in your user folder* with the name [insert folder name]
- docker_image_names: [insert image names]
- docker_container_names: [insert container names]
- docker_service_names: [insert service names]
- local_development_url:  http://[docker machine's ip address]:3000/ (e.g. [http://192.168.99.100:3000/](http://192.168.99.100:3000/))

Setup Steps:

1. Install [GIT](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git) on your local machine if you don't already have it
1. Clone this repository to your computer
    1. Create a folder (e.g. local_folder_name) in your user directory
        - Note: especially for windows users, it is very important that the folder is in your computer's user directory
    1. open up a terminal and navigate to the new folder (e.g. `cd your_user_folder/www/local_folder_name/`)
    1. run `git clone github_repo_link .`
1. Install [Docker Toolkit](https://docs.docker.com/engine/installation/)
    - Note: these instructions are written assuming you have "Docker Toolkit" and not docker for windows or mac
1. Open the "Docker Quickstart Terminal"
    - You should see a docker whale at the top of the terminal where you can type commands
        - Note: you may want to note your docker machine's IP address (e.g. 192.168.99.100)
    - Navigate your computers file system to the cloned repository folder (created above) (e.g. `cd your_user_folder/www/local_folder_name/`)
1. Magically create all the docker containers needed to run the code
    - In the quick start terminal run `docker-compose up`
    - You should expect it print a lot to the console while it
        1. builds your docker services (and by extension your images)
        1. starts your containers
        1. runs the entrypoint files for all services
1. View your site's web address
    1. Open Google Chrome (or another web browser)
    1. Visit your local_development_url
    1. Expect to see a login form

Trouble shooting your docker containers:

1. For trouble shooting docker see this [troubleshooting guide](https://github.com/bbuie/code_snipits/wiki/Docker-Trouble-Shooting)
    - You'll need to note some of the setup definitions noted above