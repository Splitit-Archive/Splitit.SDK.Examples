package main

import "github.com/splitit/splitit.sdks.go"

const (
	apiKey   = "apiKey"
	username = "username"
	password = "password"
)

var apiClient = splitit.NewSandboxAPIClient(
	apiKey,
	username,
	password,
)
