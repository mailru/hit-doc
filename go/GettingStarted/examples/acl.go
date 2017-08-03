package main

import (
	"fmt"
    "os"
    "flag"

    "github.com/aws/aws-sdk-go/aws"
    "github.com/aws/aws-sdk-go/aws/session"
    "github.com/aws/aws-sdk-go/service/s3"
)

func error(msg string, args ...interface{}) {
    fmt.Fprintf(os.Stderr, msg+"\n", args...)
    os.Exit(1)
}

func main() {
	var bucket, key string
	flag.StringVar(&bucket, "b", "", "Bucketname.")
    flag.StringVar(&key,    "k", "", "Keyname.")
    flag.Parse()

    sess := session.Must(session.NewSession(&aws.Config{
        Region: aws.String("ru-msk"),
        Endpoint: aws.String("http://hb.bizmrg.com"),
    }))
    svc := s3.New(sess)
    
    PutBucketAcl(svc, bucket, "public-read")
    GetBucketAcl(svc, bucket)
}

func PutBucketAcl(s3client *s3.S3, bucket string, public_acl string) {
	input := &s3.PutBucketAclInput{
        Bucket: aws.String(bucket),
        ACL   : aws.String(public_acl),
    }
   _, err := s3client.PutBucketAcl(input)
    
    if err != nil {
        fmt.Println(err.Error())
        return
    }
    fmt.Println("Upload BucketAcl Successfully; Acl: \"public_acl\"")
}
func GetBucketAcl(s3client *s3.S3, bucket string) {
   
    result, err := s3client.GetBucketAcl(&s3.GetBucketAclInput{Bucket: aws.String(bucket)})

    if err != nil {
        fmt.Println(err.Error())
        return
    }
    for _, g := range result.Grants {
        fmt.Println(g)
    }
}