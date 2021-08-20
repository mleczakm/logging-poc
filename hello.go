package main

import (
	"fmt"
	"net/http"
)

func pong(w http.ResponseWriter, req *http.Request) {
	fmt.Println("Started handling ping request")
	_, err := fmt.Fprintf(w, "pong\n")
	fmt.Println("Finished handling ping request")

	if err != nil {
		fmt.Print(err)
	}
}

func main() {

	http.HandleFunc("/ping", pong)

	http.ListenAndServe(":8090", nil)
}