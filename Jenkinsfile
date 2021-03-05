pipeline {
    agent { label 'epsi' }
    stages {
        stage ('clone + install dnt4') {
            steps {
                sh '''
                    echo "DATABASE_URL=mysql://epsi:epsimysql@mysql:3306/epsi" > .env.local
                    docker-compose restart
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
