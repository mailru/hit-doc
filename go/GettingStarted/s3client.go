package main

import (
	"fmt"
	"flag"
	"os"
	"strings"
	"io/ioutil"
	"github.com/aws/aws-sdk-go/aws"
	"github.com/aws/aws-sdk-go/aws/session"
	"github.com/aws/aws-sdk-go/service/s3"
	"github.com/aws/aws-sdk-go/aws/request"
	"github.com/aws/aws-sdk-go/aws/awserr"
)

func main() {
	var bucket, key, content string
	flag.StringVar(&bucket, "b", "", "Bucketname.")
    flag.StringVar(&key,    "k", "", "Keyname.")
    flag.Parse()

    sess := session.Must(session.NewSession(&aws.Config{
        Region: aws.String("ru-msk"),
        Endpoint: aws.String("http://hb.bizmrg.com"),
    }))
    svc := s3.New(sess)

    // ListObjects

    fmt.Printf("Content bucket:\n\n")
	ListObjectsErr := svc.ListObjectsPages(&s3.ListObjectsInput{
		Bucket: aws.String(bucket),
	}, func(p *s3.ListObjectsOutput, last bool) (shouldContinue bool) {
		for _, obj := range p.Contents {
			fmt.Println("Object:", *obj.Key)
		}
		return true
	})
	if err != nil {
		if aerr, ok := err.(awserr.Error); ok && aerr.Code() == request.CanceledErrorCode {
			fmt.Fprintf(os.Stderr, "upload canceled due to timeout, %v\n", err)
		} else {
			fmt.Fprintf(os.Stderr, "failed to upload object, %v\n", err)
		}
		os.Exit(1)
	}
	// PutObject
	content = "content of object"
	_, puterr := svc.PutObject(&s3.PutObjectInput{
		Bucket: aws.String(bucket),
		Key:    aws.String(key),
		Body:   strings.NewReader(content),
	})
	if puterr != nil {
		if aerr, ok := puterr.(awserr.Error); ok && aerr.Code() == request.CanceledErrorCode {
			fmt.Fprintf(os.Stderr, "upload canceled due to timeout, %v\n", puterr)
		} else {
			fmt.Fprintf(os.Stderr, "failed to upload object, %v\n", puterr)
		}
		os.Exit(1)
	}

	fmt.Printf("\nSuccessfully uploaded file to %s/%s\n", bucket, key)
	fmt.Printf("Content of uploaded file is: \"%s\"\n\n", content)

	// GetObject
	resp, geterr := svc.GetObject(&s3.GetObjectInput{
		Bucket: aws.String(bucket),
		Key:    aws.String(key),
	})

	if geterr != nil {
		if aerr, ok := puterr.(awserr.Error); ok && aerr.Code() == request.CanceledErrorCode {
			fmt.Fprintf(os.Stderr, "upload canceled due to timeout, %v\n", puterr)
		} else {
			fmt.Fprintf(os.Stderr, "failed to upload object, %v\n", puterr)
		}
		os.Exit(1)
	}
	fmt.Printf("Successfully downloaded file %s/%s\n", bucket, key)
	
	plaintext, err := ioutil.ReadAll(resp.Body)
	
	fmt.Printf("Content of downloading object \"%s\"\n\n",plaintext)
}
