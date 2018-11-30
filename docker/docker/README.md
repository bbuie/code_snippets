### Setup Using Docker

You're about to experience the awesomeness of local development with docker. The steps below should allow you to effortlessly spin up a local environment that will be identical to the environment used by other developers on this project and very similar to the production environment. If this is your first time using docker, you'll probably have some questions like how to debug, how to connect to the local database, etc., but once you get over the initial learning curve, you may never go back.

Using docker for local development is a bit of a paradigm shift. The most important thing to keep in mind is that if you hit a bug with your local environment, you can bet that others will (or are) too. Instead of just fixing the issue on your virtual machine/container, we now need to fix it in the docker setup so that everyone gets the fix the next time they build their environment.

##Docker setup definitions:

- git_base_repo_link: [insert repo link]
- local_folder_name: [insert folder name] - We recommend you create a folder *in your USER folder* with this name
- docker_image_names: see [docker-compose.yml](../docker-compose.yml)
- docker_container_names: see [docker-compose.yml](../docker-compose.yml)
- docker_service_names: see [docker-compose.yml](../docker-compose.yml)
- local_development_url:  [http://192.168.99.100/](http://192.168.99.100/)
- containers_finished_running_string: "[docker_container_names] is running!"

##Before you begin:

- Make sure you're ready to take notes of any and all issues you have. If you have to do anything outside of the steps below, we need to note them here for future developers.
- If you have to do anything outside of the steps below, we need to note them here for future developers.
- Ask questions! If you run into a roadblock, ask for help.

##Pre-Setup Steps:

1. Add repository specific steps here if any.


##Setup Steps:

1. Install GIT on your local machine if you don't already have it
1. Download the code to your local machine
    1. Clone this repository to your computer
        1. Create a folder (e.g. local_folder_name) in `your_user_folder` directory
            - Note: especially for windows OS, it is very important that the folder is in your computer's USER directory!
        1. open up a terminal and navigate to the new folder (e.g. `cd your_user_folder/local_folder_name/`)
        1. run `git clone git_base_repo_link .`
    1. Import sub modules
        1. run `git submodule update --init --recursive`
        1. if this project doesn't have submodules, nothing will happen here
    1. Download other code that may be needed
        1. Some local environment setups require multiple codebases. If this is the case for this code base, you'll find more steps below under the header "Steps to download code unique to this repository". Follow these steps now.
1. Install docker
    - *MacOS/Windows*
        - Install [Docker Toolbox](https://docs.docker.com/toolbox/overview/)
        - Note: these instructions are written assuming you have Docker "Toolbox" for your operating system and not Docker "CE" or "EE"
        - Note: you'll need to have [VirtualBox](https://www.virtualbox.org/wiki/Downloads) as part of the docker tool box install (unless it is already installed on your machine). It is important that your local environment is run on a virtual machine.
    - *Linux*
        - Install docker and docker-compose.
        - Allow docker root permissions if asked.
        - Add docker to your startup applications
1. Open the "Docker Quickstart Terminal"
    - You should see a docker whale at the top of the terminal where you can type commands
        - Note: you may want to note your docker machine's IP address (e.g. 192.168.99.100)
    - Navigate your computers file system to the cloned repository folder (created above) (e.g. `cd your_user_folder/local_folder_name/`)
    - Note: Linux doesn't use docker's quick terminal, instead use docker exec to run commands on the containers.
1. Magically create all the docker containers needed to run the code
    - In the quick start terminal run `docker-compose down -v; docker-compose up --build`
        - Note Linux users: docker needs root access to run properly. If you get an error try to run `sudo docker-compose up --build`
    - You should expect it print a lot to the console while it...
        1. builds your docker services (and by extension your images)
        1. starts your containers
        1. runs the entrypoint files for all services
    - Don't wait around, this takes a while so go do something else productive
        - Note: you may see some warnings and even some errors (hopefully not errors) but as long as you don't see a container exit, then you're probably in good shape.
    - Containers are not ready till you see your containers_finished_running_string (see above)
        - You may have to search this string in your console from time to time just to make sure it is done
        - If you ever see a string similar to "docker_container_names exited with code 0" then something went wrong
1. View your site's local_development_url
    1. Open Google Chrome (or another web browser)
    1. Visit your local_development_url
    1. Expect to see a login form

##Steps to download code unique to this repository

1. Add repository specific steps here if any.

##Troubleshooting this repository

1. Add repository specific steps

##Trouble shooting your docker containers:

1. For trouble shooting docker see this [troubleshooting guide](https://github.com/bbuie/code_snipits/wiki/Docker-Trouble-Shooting)
    - You'll need to note some of the setup definitions noted above
