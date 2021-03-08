pipeline {
    agent { label 'epsi' }
    stages {
        stage ('clone + install dnt4') {
            steps {
                sh '''
                    cp .env.example .env
                    docker-compose down
                    docker-compose up -d
                    docker-compose exec -T php composer install
                    docker-compose exec -T php sh -c "php bin/console doctrine:schema:update --force"
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
