package main

import (
	"fmt"
	"log"
	"net/http"
)

func httpError(w http.ResponseWriter, code int, format string, args ...interface{}) {
	text := fmt.Sprintf(format, args...)
	log.Println(text)
	http.Error(w, text, code)
}
