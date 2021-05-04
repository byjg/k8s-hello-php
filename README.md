# Kubernetes Hello World PHP

This project is intended to be used as a sample for 
deployment of kubernetes applications. 

Basically this expose 3 apis:
- /ping
- /current-date
- /stress/:n

The last one is good to test the capacity of the cluster by implement 
a loop based on a number 10^n. If n>6 is good to stress your server. n>8 can crash your server :)

# Start

Build the image

```
docker build -t byjg/k8s-hello-php .
```

Run the Image

```
docker run -d -p 8080:80 byjg/k8s-hello-php
```

# Deploying in the Kubernetes cluster

First create the Pods and the autoscale 

```
kubectl apply -f kubernetes/deployment.yml
```

Check if is OK:

```
kubectl get pods -l app=k8s-php -o yaml | grep podIP
```

# Exposing the Api to the World:

```
kubectl apply -f kubernetes/service-external.yml
```

Checking:

```
kubectl get service
```

Run this to see the auto scaling working:

```
ab -n 500 -c 10 -s 600 http://<IP>/fibo/35
```

# Exposing the Api inside the cluster:


```
kubectl apply -f kubernetes/service-external.yml
```

Checking:

```
kubectl run terminal --generator=run-pod/v1 --image=alpine:3.8 -i --tty
```