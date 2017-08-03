<?php
    require '../../../vendor/autoload.php';
    use Aws\S3\S3Client;
    use PHPUnit\Framework\TestCase;

    class s3test extends TestCase
    {
        public function testPutObject(): void
        {
            $bucket  = "jiraf";
            $key     = "sdk_file";
            $content = "body_content";
            
            $sharedConfig = [
                'region'  => 'us-west-2',
                'version' => 'latest',
                'endpoint' => 'http://hb.devmail.ru'
            ];
            
            // Create an SDK class used to share configuration across clients.
            $sdk = new Aws\Sdk($sharedConfig);
            
            // Create an Amazon S3 client using the shared configuration data.
            $s3Client = $sdk->createS3();
            $s3Client->putObject([
                'Key'    => $key,
                'Bucket' => $bucket,
                'Body'   => $content,
            ]);
            $result = $s3Client->getObject([
                'Bucket' => $bucket,
                'Key'    => $key,
            ]);
            $this->assertEquals(
                $content,
                $result['Body']
            );
        }
        public function testPutAclObject(): void
        {
            $bucket = "jiraf";
            $key    = "sdk_file";
        
            $params = [
                'ACL'    => 'public-read',
                'Bucket' => $bucket,
                'Key'    => $key
            ];
            $sdk = new Aws\Sdk([
                'region'  => 'us-west-2',
                'version' => 'latest',
                'endpoint' => 'http://hb.devmail.ru'
            ]);

            $s3Client = $sdk->createS3();
            try {
                $result = $s3Client->putObjectAcl($params);
            } catch (AwsException $e) {
                echo $e->getMessage() . "\n";
            }
            $this->assertEquals(
                200,
                $result["@metadata"]['statusCode']
            );
        }
        public function testGetAclObject(): void
        {
            $bucket  = "jiraf";
            $key     = "sdk_file";
            $content = "body_content";

            $sharedConfig = [
                'region'  => 'us-west-2',
                'version' => 'latest',
                'endpoint' => 'http://hb.devmail.ru',
            ];

            // Create an SDK class used to share configuration across clients.
            $sdk = new Aws\Sdk($sharedConfig);

            // Create an Amazon S3 client using the shared configuration data.
            $s3Client = $sdk->createS3();
            try {
                $result = $s3Client->getObjectAcl([
                    'Bucket' => $bucket,
                    'Key'    => $key
                ]);
            } catch (AwsException $e) {
                 // output error message if fails
                echo $e->getMessage();
                echo "\n";
            }
            $this->assertEquals(
                "http://acs.amazonaws.com/groups/global/AllUsers",
                $result["Grants"][1]["Grantee"]["URI"]
            );
                $this->assertEquals(
                "READ",
                $result["Grants"][1]["Permission"]
            );
        }
    }
?>
