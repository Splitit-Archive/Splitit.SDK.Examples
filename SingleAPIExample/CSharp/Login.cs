using Splitit.SDK.Client.Api;
using Splitit.SDK.Client.Client;
using Splitit.SDK.Client.Model;

namespace Examples
{
    public class LoginExample
    {
        public void Login(string username, string password)
        {
            var loginApi = new LoginApi(Configuration.Sandbox);
            var request = new LoginRequest(username, password);

            var loginResult = loginApi.LoginPost(request);

            var planApi = new InstallmentPlanApi(Configuration.Sandbox, loginResult.SessionId);
        }
    }
}
