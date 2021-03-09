pipeline {
    agent { label 'epsi' }
    stages {
        stage ('clone + install dnt4-test') {
            steps {
                sh '''
                    echo "MYSQL_ROOT_PASSWORD=epsiroot\nMYSQL_DATABASE=epsi\nMYSQL_USER=epsi\nMYSQL_PASSWORD=epsimysql\nLOCAL_USER=1001\nMYSQL_PORT=3306\nNGINX_PORT=80\nADMINER_PORT=8000" > .env.example
                    echo "DATABASE_URL=mysql://epsi:epsimysql@mysql:3306/epsi" > .env.local
                    rm docker/php/Dockerfile
                    mv docker/php/DockerfileJenkins docker/php/Dockerfile
                    docker-compose --env-file .env.example up -d
                    docker-compose exec -T php composer install
                    docker-compose exec -T php php bin/console doctrine:schema:create
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
