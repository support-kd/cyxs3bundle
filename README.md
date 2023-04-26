Amazon S3 Bundle
======================

This bundle integrates Amazon S3 API in Symfony.

1. [Installation](#1-installation)
2. [Configuration](#2-configuration)
3. [Usage](#3-usage)

### 1. Installation

Add Tron Repository in symfony composer

``` json
# composer

"repositories": [
        {"type": "vcs", "url": "https://github.com/support-kd/cyxauthbundle"}
    ],
```

Run from terminal:

```bash
$ composer require SupportKd/CyxS3Bundle
```

Enable bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // ...
        new SupportKd\CyxS3Bundle\SupportKdCyxS3Bundle(),
    ];
}
```

### 2. Configuration

Add following lines in your configuration:

``` yaml
# app/config/config.yml

support_kd_cyx_s3:
    key: "%amazon_s3_key%"
    secret: "%amazon_s3_secret%"
    region: "%amazon_s3_region%"
    version: "%amazon_s3_version%"
```


### 3. Usage

[Check out document](http://docs.aws.amazon.com/aws-sdk-php/v3/guide/index.html) to get started using AWS SDK for PHP

#### 3.1: Put Files

``` php
#include CyxS3Model in your Controller

$s3 = new CyxS3Model($this->container);

#set Bucket Name
$s3->setBucket($bucket);

#set Local Image Path
$s3->setPath($path);

#set file Permission
$s3->setAcl('public-read');

#put files
$s3->putObject($fileName);
```

#### 3.2: Get Files

``` php
#include CyxS3Model in your Controller

$s3 = new CyxS3Model($this->container);
// Make a request
$result = $s3->getObject($fileName, $bucket);

#get Public File View URL
$imageUrl = $result['@metadata']['effectiveUri'];
<img src="<?php echo $imageUrl; ?>" />

```
#### 3.3: Get Pre Signed Url

``` php
#include CyxS3Model in your Controller

$s3 = new CyxS3Model($this->container);
// Make a request and this url will expairs after given time
$imageUrl = $s3->getPresignedUrl($fileName, $bucket, $time)
<img src="<?php echo $imageUrl; ?>" />

```
