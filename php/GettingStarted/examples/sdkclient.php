<?php
    require '../../vendor/autoload.php';
    use Aws\S3\S3Client;
    use PHPUnit\Framework\TestCase;

    class s3test extends TestCase
    {
        const BUCKET = 'newbucket';
        const KEY = 'sdk_file';
        
        public function testPutObject(): void
        {
            $content = "body_content";
            
            $sharedConfig = [
                'region'  => 'ru-msk',
                'version' => 'latest',
                'endpoint' => 'http://hb.bizmrg.com'
            ];
            
            // Create an SDK class used to share configuration across clients.
            $sdk = new Aws\Sdk($sharedConfig);
            
            // Create an Amazon S3 client using the shared configuration data.
            $s3Client = $sdk->createS3();
            $s3Client->putObject([
                'Key'    => self::KEY,
                'Bucket' => self::BUCKET,
                'Body'   => $content,
            ]);
            $result = $s3Client->getObject([
                'Key'    => self::KEY,
                'Bucket' => self::BUCKET,
            ]);
            $this->assertEquals(
                $content,
                $result['Body']
            );
        }
        public function testPutAclObject(): void
        {
            $params = [
                'ACL'    => 'public-read',
                'Key'    => self::KEY,
                'Bucket' => self::BUCKET,
            ];
            $sdk = new Aws\Sdk([
                'region'  => 'ru-msk',
                'version' => 'latest',
                'endpoint' => 'http://hb.bizmrg.com'
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
            $content = "body_content";

            $sharedConfig = [
                'region'  => 'ru-msk',
                'version' => 'latest',
                'endpoint' => 'http://hb.bizmrg.com'
            ];

            // Create an SDK class used to share configuration across clients.
            $sdk = new Aws\Sdk($sharedConfig);

            // Create an Amazon S3 client using the shared configuration data.
            $s3Client = $sdk->createS3();
            try {
                $result = $s3Client->getObjectAcl([
                    'Key'    => self::KEY,
                    'Bucket' => self::BUCKET,
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
