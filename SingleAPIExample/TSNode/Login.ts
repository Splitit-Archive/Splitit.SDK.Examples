import { InstallmentPlanApi, LoginApi, Configuration } from 'splitit-sdk-nodejs'

let planApi: InstallmentPlanApi

export async function login(userName: string, password: string) {
  const loginApi = new LoginApi(Configuration.sandbox)

  const { body: loginResult } = await loginApi.loginPost({ userName, password })

  var planApi = new InstallmentPlanApi(Configuration.sandbox, loginResult.sessionId)
}
