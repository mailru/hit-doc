package main

import (
	"crypto/hmac"
	"crypto/sha256"
	"encoding/hex"
)

type SubscriptionConfirmation struct {
	Timestamp        string // we need to give it to hmac byte-for-byte, "2019-12-26T19:29:12+03:00",
	Type             string // always "SubscriptionConfirmation",
	Message          string // always "You have chosen to subscribe to the topic $topic. To confirm the subscription you need to response with calculated signature",
	TopicArn         string // for feeding into signature, "mcs2883541269|bucketA|s3:ObjectCreated:Put",
	SignatureVersion int64  // always 1,
	Token            string // for feeding into signature, "RPE5UuG94rGgBH6kHXN9FUPugFxj1hs2aUQc99btJp3E49tA"
}

// signSubscriptionHex returns hex-encoded signature for SNS webhook subscription confirmation
func signSubscriptionHex(decoded SubscriptionConfirmation, fullURL string) string {
	return hex.EncodeToString(signSubscription(decoded, fullURL))
}

// signSubscription returns array with a signature for SNS webhook subscription confirmation
func signSubscription(decoded SubscriptionConfirmation, fullURL string) []byte {
	// get timestamp+token hash first
	firstMAC := hmac.New(sha256.New, []byte(decoded.Token))
	firstMAC.Write([]byte(decoded.Timestamp))
	firstHash := firstMAC.Sum(nil)
	// then combine that with TopicArn
	secondMAC := hmac.New(sha256.New, firstHash)
	secondMAC.Write([]byte(decoded.TopicArn))
	secondHash := secondMAC.Sum(nil)
	// then combine that with full URL
	thirdMAC := hmac.New(sha256.New, secondHash)
	thirdMAC.Write([]byte(fullURL))
	thirdHash := thirdMAC.Sum(nil)
	return thirdHash
}
