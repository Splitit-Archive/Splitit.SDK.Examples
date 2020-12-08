import com.splitit.*;
import com.splitit.sdk.model.*;
import java.math.BigDecimal;


public class Get {
    private String apiKey, username, password;
    public Get(String username, String password, String apiKey){
        this.username = username;
        this.password = password;
        this.apiKey = apiKey;
    }

    public void example(String ipn) throws ApiException{
        ApiClient apiClient = new ApiClient()
            .sandbox(true)
            .username(username)
            .password(password)
            .apiKey(apiKey);


        var result = apiClient.getInstallmentPlanApi().installmentPlanGet(
            new GetInstallmentsPlanSearchCriteriaRequest()
            .queryCriteria(
                new InstallmentPlanQueryCriteria()
                .installmentPlanNumber(ipn)
            )
        );
        System.out.println(result);
    }
}
