<?php
    require '../../../vendor/autoload.php';
    use Aws\S3\S3Client;
    use Aws\Exception\AwsException;
    use Aws\S3\Exception\S3Exception;
    
    $bucket = 'jiraf';
    $key = 'my-key';
    $content = 'this is the body!';
    
    // s3 client 
    // aws access_keys are contained in credentilas
 
    $FirstS3Client = new S3Client([
        'version' => 'latest',
        'region'  => 'us-east-1',
        'credentials' => [
            'key'    => '6B7hCqne2PnWonbS9wZQie',
            'secret' => '5QDoD91JUhqRN88oA1UfDGJJk4F4KGBi6hQfiTqgez8B',
        ],
        'endpoint' => 'http://hb.devmail.ru'
    ]);
    try { 
        $result = $FirstS3Client->putObject([
            'Bucket' => $bucket,
            'Key'    => $key,
            'Body'   => $content
        ]);
        echo $result["@metadata"]["statusCode"] . "\n";
    } catch (S3Exception $e) {
        echo $e->getMessage();
    } catch (AwsException $e) {
        echo $e->getAwsRequestId() . "\n";
        echo $e->getAwsErrorType() . "\n";
        echo $e->getAwsErrorCode() . "\n";
    }
    
    // s3 client
    // aws access_keys are contained in main block

    $SecondS3Client = new S3Client([
        'version' => 'latest',
        'region'  => 'us-east-1',
        'key'    => '6B7hCqne2PnWonbS9wZQie',
        'secret' => '5QDoD91JUhqRN88oA1UfDGJJk4F4KGBi6hQfiTqgez8B',
        'endpoint' => 'http://hb.devmail.ru'
    ]);
    try {
        $result = $SecondS3Client->putObject([
            'Bucket' => $bucket,
            'Key'    => $key,
            'Body'   => $content
        ]);
        echo $result["@metadata"]["statusCode"] . "\n";
    } catch (S3Exception $e) {
        echo $e->getMessage();
    } catch (AwsException $e) {
        echo $e->getAwsRequestId() . "\n";
        echo $e->getAwsErrorType() . "\n";
        echo $e->getAwsErrorCode() . "\n";
    }

    // sdk client 
    // aws access_keys are contained in credentials

    $sdk = new Aws\Sdk ([
        'version' => 'latest',
        'region'  => 'us-east-1',
        'credentials' => [
            'key'    => '6B7hCqne2PnWonbS9wZQie',
            'secret' => '5QDoD91JUhqRN88oA1UfDGJJk4F4KGBi6hQfiTqgez8B',
        ],
        'endpoint' => 'http://hb.devmail.ru'
    ]);
    $ThirdS3Client = $sdk->createS3();
    try {
        $result = $ThirdS3Client->putObject([
            'Bucket' => $bucket,
            'Key'    => $key,
            'Body'   => $content
        ]);
        echo $result["@metadata"]["statusCode"] . "\n";
    } catch (S3Exception $e) {
        echo $e->getMessage();
    } catch (AwsException $e) {
        echo $e->getAwsRequestId() . "\n";
        echo $e->getAwsErrorType() . "\n";
        echo $e->getAwsErrorCode() . "\n";
    }
    
    // sdk client
    // aws access_keys are contained in main block

    $second_sdk = new Aws\Sdk ([
        'version' => 'latest',
        'region'  => 'us-east-1',
        'credentials' => [
            'key'    => '6B7hCqne2PnWonbS9wZQie',
            'secret' => '5QDoD91JUhqRN88oA1UfDGJJk4F4KGBi6hQfiTqgez8B',
        ],
        'endpoint' => 'http://hb.devmail.ru'
    ]);
    $FourthS3Client = $second_sdk->createS3();
    try {
        $result =  $FourthS3Client->putObject([
            'Bucket' => $bucket,
            'Key'    => $key,
            'Body'   => $content
        ]);
        echo $result["@metadata"]["statusCode"] . "\n";
    } catch (S3Exception $e) {
        echo $e->getMessage();
    } catch (AwsException $e) {
        echo $e->getAwsRequestId() . "\n";
        echo $e->getAwsErrorType() . "\n";
        echo $e->getAwsErrorCode() . "\n";
    }
    // s3 client
    $credentials = new Aws\Credentials\Credentials('6B7hCqne2PnWonbS9wZQie', '5QDoD91JUhqRN88oA1UfDGJJk4F4KGBi6hQfiTqgez8B');

    $FifthS3Client = new Aws\S3\S3Client([
        'version'     => 'latest',
        'region'      => 'us-west-2',
        'credentials' => $credentials,
        'endpoint' => 'http://hb.devmail.ru'
    ]);
    try {
        $result = $FifthS3Client->putObject([
            'Bucket' => $bucket,
            'Key'    => $key,
            'Body'   => $content
        ]);
        echo $result["@metadata"]["statusCode"] . "\n";
    } catch (S3Exception $e) {
        echo $e->getMessage();
    } catch (AwsException $e) {
        echo $e->getAwsRequestId() . "\n";
        echo $e->getAwsErrorType() . "\n";
        echo $e->getAwsErrorCode() . "\n";
    }
?>
