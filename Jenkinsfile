pipeline {
    agent { label 'epsi' }
    stages {
        stage ('clone + install dnt4') {
            steps {
                sh '''
                    echo "DATABASE_URL=mysql://epsi:epsimysql@mysql:3306/epsi" > .env.local
                    docker-compose restart
                    winpty docker-compose exec php composer install
                    winpty docker-compose exec php php bin/console doctrine:schema:create
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
