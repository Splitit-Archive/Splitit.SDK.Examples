package main

import (
	"context"
	"fmt"

	"github.com/splitit/splitit.sdks.go"
)

// Example of login request. Ususally SDK performs it automatically
// when needed (if SessionID is missing or expired)
func Login() {
	loginResponse, _, err := apiClient.LoginApi.LoginPost(
		context.Background(),
		splitit.LoginRequest{
			UserName: username,
			Password: password,
		},
	)

	if err != nil {
		fmt.Printf("Error: %s\n", err)
		return
	}
	fmt.Printf("Successfully logged in, session id: %s\n", loginResponse.SessionId)
}
