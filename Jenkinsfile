pipeline {
    agent { label 'epsi' }
    stages {
        stage ('install dnt4 test') {
            steps {
                sh '''
                    echo "LOCAL_USER=1001\nMYSQL_PORT=3307\nNGINX_PORT=81\nADMINER_PORT=8001\nDATABASE_URL=mysql://epsi:epsimysql@mysql:3306/epsi?serverVersion=8.0" > .env.local
                    rm docker/php/Dockerfile
                    mv docker/php/DockerfileJenkins docker/php/Dockerfile
                    docker-compose down
                    docker-compose --env-file .env.local up -d
                    docker-compose exec -T php composer install
                    sleep 120
                    docker-compose exec -T php php bin/console doctrine:schema:update -f --complete
                '''
            }
        }
        stage ('Unit test + Integration test') {
            steps {
                sh '''
                    curl http://localhost:81/api
                '''
            }
        }
        stage ('install dnt4 prod') {
            steps {
                sh '''
                    echo "LOCAL_USER=1001\nMYSQL_PORT=3306\nNGINX_PORT=80\nADMINER_PORT=8000\nDATABASE_URL=mysql://epsi:epsimysql@mysql:3306/epsi?serverVersion=8.0" > .env.local
                    rm docker/php/Dockerfile
                    mv docker/php/DockerfileJenkins docker/php/Dockerfile
                    docker-compose down
                    docker-compose --env-file .env.local up -d
                    docker-compose exec -T php composer install
                    sleep 120
                    docker-compose exec -T php php bin/console doctrine:schema:update -f --complete
                '''
            }
        }
        stage('Smoke test production') {
            steps {
                sh '''
                    curl http://212.194.165.52/api
                '''
            }
        }
    }  
}
