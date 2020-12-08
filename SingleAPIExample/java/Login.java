import com.splitit.*;
import com.splitit.sdk.model.*;


/**
 * Example of login request. Ususally SDK performs it automatically
 * when needed (if SessionID is missing or expired)
 */
public class Login {
    private String apiKey, username, password;
    public Login(String username, String password, String apiKey){
        this.username = username;
        this.password = password;
        this.apiKey = apiKey;
    }

    public void example() throws ApiException{
        ApiClient apiClient = new ApiClient()
            .sandbox(true)
            .apiKey(apiKey);

        var result = apiClient.getLoginApi().loginPost(
            new LoginRequest()
            .userName(username)
            .password(password)
        );
        System.out.println(result);
    }
}
