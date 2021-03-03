pipeline {
    agent epsi
    stages {
        stage ('clone + install dnt4-test') {
            steps {
                sh '''
                    rm dnt4-test
                    git clone https://github.com/epsi-mat/dnt4.git dnt4-test
                    cd dnt4-test
                    echo -e "MYSQL_ROOT_PASSWORD=epsiroot\nMYSQL_DATABASE=epsi\nMYSQL_USER=epsi\nMYSQL_PASSWORD=epsimysql\nLOCAL_USER=$UID:$UID\nMYSQL_PORT=3307\nNGINX_PORT=81\nADMINER_PORT=8001" > .env.test
                    echo -e "DATABASE_URL=mysql://epsi:epsimysql@mysql:3306/epsi" > .env.local
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
        stage('Deploy') {
            steps {
                sh '''
                    cd jenkins
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
