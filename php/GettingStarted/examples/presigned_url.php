<?php
    require '../../vendor/autoload.php';
    use Aws\S3\S3Client;
    use PHPUnit\Framework\TestCase;
    
    class s3test extends TestCase
    {
        const BUCKET = 'newbucket';
        const KEY = 'sdk_file';

         public function testUrl(): void
         {
         	$content = "body_content";
         	$s3Client = new S3Client([
                'credentials' => [
                    'key'    => 'AccessKeyEXAMPLE',
                    'secret' => 'TheVeryLongLongLongSecretKeyEXAMPLE',
                ],
                'endpoint' => 'https://hb.bizmrg.com',
                'region'   => 'ru-msk',
                'version'  => 'latest',
            ]);
         	$res = $s3Client->putObject([
                'Key'    => self::KEY,
                'Bucket' => self::BUCKET,
                'Body'   => $content,
            ]);
            $cmd = $s3Client->getCommand('GetObject', [
			    'Bucket' => self::BUCKET,
			    'Key'    => self::KEY,
			]);

			$request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
			// var_dump ($request);
			$presignedUrl = (string) $request->getUri();
			print ($presignedUrl);
			$page = file_get_contents($presignedUrl);
			print($page);
			$this->assertEquals(
                $content,
                $page
            );
         }
    }
?>