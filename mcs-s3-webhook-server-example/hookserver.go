package main

import (
	"encoding/json"
	"fmt"
	"log"
	"net/http"
	"net/http/httputil"
	"strings"
)

func main() {
	http.HandleFunc("/", ServeHTTP)
	log.Fatal(http.ListenAndServe(":33345", nil))
}

// general handler for all http requests
func ServeHTTP(w http.ResponseWriter, r *http.Request) {
	// dump all requests to stdout
	dump, err := httputil.DumpRequest(r, true)
	if err != nil {
		httpError(w, http.StatusInternalServerError, "Failed to dump request")
		return
	}
	fmt.Printf("%s\n", dump)

	// X-Amz-Sns-Message-Type: SubscriptionConfirmation
	snsType := strings.ToLower(r.Header.Get("X-Amz-Sns-Message-Type"))
	switch snsType {
	case "subscriptionconfirmation":
		handleSubscriptionConfirmation(w, r)
	case "notification":
		handleNotification(w, r)
	default:
		httpError(w, http.StatusBadRequest, "Invalid SNS message type")
	}
}

// handle all subscription confirmations
func handleSubscriptionConfirmation(w http.ResponseWriter, r *http.Request) {
	decoded := SubscriptionConfirmation{}
	err := json.NewDecoder(r.Body).Decode(&decoded)
	if err != nil {
		httpError(w, http.StatusBadRequest, "Failed to decode JSON in the body: %s", err)
		return
	}

	// assume https
	fullURL := fmt.Sprintf("https://%s%s", r.Host, r.URL.String()) // r.URL doesn't contain protocol or host

	response := struct {
		Signature string `json:"signature"` // base64-encoded signature
	}{
		Signature: signSubscriptionHex(decoded, fullURL),
	}
	w.Header().Set("Content-Type", "application/json")
	jsonBody, err := json.Marshal(&response)
	if err != nil {
		httpError(w, http.StatusInternalServerError, "Failed to marshal json: %s", err)
		return
	}

	log.Printf("Responding with body: %s", jsonBody)
	w.Write(jsonBody)
}

func handleNotification(w http.ResponseWriter, r *http.Request) {
	// do nothing, just 200, we dump the request body in main handler already
}
