# Setup Instructions

Remove .git directory from docker/.git use `rm docker/.git -rf`

1. Clone package to your project root and open terminal in docker folder.

2. Update your project configurations in .env file. Do not wrap values in single or double quoutes. 

3. Run `docker-compose build`.

4. Run `docker-compose up`.

5. If necessory you can make updated to docker-compose and docker file too.

6. supervisor is included in this configurations and you can add more files to super visor directory. A sample config file is already included.
