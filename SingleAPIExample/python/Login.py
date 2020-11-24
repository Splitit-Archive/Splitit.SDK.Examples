import splitit

username, password, api_key = (
    "username",
    "password",
    "api_key",
)

api_client = splitit.ApiClient(splitit.Configuration(username, password, api_key, sandbox=True))

# Example of login request. Ususally SDK performs it automatically
# when needed (if SessionID is missing or expired)


def login():
    resp = api_client.LoginApi.login_post(
        splitit.LoginRequest(
            user_name=username,
            password=password,
        )
    )
    return resp
