# little-fashion - DevOps deployment

Prereqs:
- Docker Hub account (update IMAGE in Jenkinsfile and k8s)
- AWS account with programmatic credentials
- Jenkins with Docker/kubectl/awscli/terraform/helm installed on agent
- Helm and kubectl locally if testing

Quick local test:
1. Put your HTML files into src/main/resources/static/
2. mvn package
3. docker build -t YOUR_DOCKERHUB_USER/little-fashion:local .
4. docker run -p 8080:8080 YOUR_DOCKERHUB_USER/little-fashion:local

Deploy to AWS EKS (via Jenkins):
- Set Jenkins credentials:
  - dockerhub-creds (user/pass)
  - aws-credentials (AWS access key)
- Run pipeline. It will:
  - build maven + jar
  - build docker image and push to Docker Hub
  - terraform apply (creates VPC + EKS)
  - update kubeconfig
  - kubectl apply k8s manifests
  - install prometheus+grafana with helm

Alternate: Ansible playbook to deploy static files to VM.
