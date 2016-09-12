# OpenRefine Transformation

WORK IN PROGRESS!

## Version

The current version is **OpenRefine 2.6 Beta 1**. 
Batch processing uses [https://github.com/fusepoolP3/p3-batchrefine](P3 BatchRefine 1.1.7). 

## Build

```
docker-compose build
```

## OpenRefine Sandbox
 
```
docker-compose up openrefine-transformation-dev
```

And point your browser to [localhost:3333](http://localhost:3333)

### Storing transformation

Go to *Undo / Redo* and click on *Extract...* button. JSON representation of the transformation is available. 
From there you can copy & paste it where required.

![](./docs/extract-json.png)

## Batch Processing

Store the 

## Libraries

Currently only P3 BatchRefine is working. 

[OpenRefine Python Client Library](https://github.com/PaulMakepeace/refine-client-py) was work in progress, but has no CLI. 
Will be deleted in the future.  


