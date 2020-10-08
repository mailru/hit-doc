package main

import "testing"

// signature = hmac_sha256_hex(“http://test.com”,
//                 hmac_sha256(“mcs2883541269|bucketA|s3:ObjectCreated:Put”,
//                 hmac_sha256(“2019-12-26T19:29:12+03:00”, “RPE5UuG94rGgBH6kHXN9FUPugFxj1hs2aUQc99btJp3E49tA”)))
// results in ea3fce4bb15c6de4fec365d36bcebbc34ccddf54616d5ca12e1972f82b6d37af
func TestSubscriptionConfirmationSignature(t *testing.T) {
	fullURL := "http://test.com"
	confirmation := SubscriptionConfirmation{
		Timestamp:        "2019-12-26T19:29:12+03:00",
		Type:             "",
		Message:          "",
		TopicArn:         "mcs2883541269|bucketA|s3:ObjectCreated:Put",
		SignatureVersion: 1,
		Token:            "RPE5UuG94rGgBH6kHXN9FUPugFxj1hs2aUQc99btJp3E49tA",
	}
	signature := signSubscriptionHex(confirmation, fullURL)
	expected := "ea3fce4bb15c6de4fec365d36bcebbc34ccddf54616d5ca12e1972f82b6d37af"
	if signature != expected {
		t.Errorf("Wrong signature, expected %s, got %s", expected, signature)
	}
}

func BenchmarkSubscriptionConfirmationSignature(b *testing.B) {
	fullURL := "http://test.com"
	confirmation := SubscriptionConfirmation{
		Timestamp:        "2019-12-26T19:29:12+03:00",
		Type:             "",
		Message:          "",
		TopicArn:         "mcs2883541269|bucketA|s3:ObjectCreated:Put",
		SignatureVersion: 1,
		Token:            "RPE5UuG94rGgBH6kHXN9FUPugFxj1hs2aUQc99btJp3E49tA",
	}
	expected := "ea3fce4bb15c6de4fec365d36bcebbc34ccddf54616d5ca12e1972f82b6d37af"
	bytes := len(confirmation.Timestamp) + len(confirmation.TopicArn) + len(confirmation.Token) + len(fullURL) + len(expected)
	b.SetBytes(int64(bytes))
	b.ResetTimer()
	for i := 0; i < b.N; i++ {
		signature := signSubscriptionHex(confirmation, fullURL)
		if signature != expected {
			b.Errorf("Wrong signature, expected %s, got %s", expected, signature)
		}
	}
}
