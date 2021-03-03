pipeline {
    agent { label 'epsi' }
    stages {
        stage ('clone + install dnt4-test') {
            steps {
                sh '''
                    echo "MYSQL_ROOT_PASSWORD=epsiroot\nMYSQL_DATABASE=epsi\nMYSQL_USER=epsi\nMYSQL_PASSWORD=epsimysql\nLOCAL_USER=$UID:$UID\nMYSQL_PORT=3307\nNGINX_PORT=81\nADMINER_PORT=8001" > .env.test
                    echo "DATABASE_URL=mysql://epsi:epsimysql@mysql:3306/epsi" > .env.local
                    docker-compose --env-file .env.test up -d
                    docker-compose exec php composer install
                    docker-compose exec php php bin/console doctrine:schema:create
                '''
            }
        }
        stage ('Unit test + Integration test') {
            steps {
                sh '''
                    pwd
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
