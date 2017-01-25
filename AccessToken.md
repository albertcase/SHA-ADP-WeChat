# Access Token调用文档
---
#### 接口

API 接口:

URL: http://adpwechat.samesamechina.com/wechat/retrieve/access_token/{key}

HTTP Methods: GET

Param:

```javascript
{
  key: XKXM9LKQYFAPKH48
}
```

Return :
```javascript
{
  status: 'success',
  data: '69rymTHJs2XATXmmSFWNblyCvFdRc2BWYhsRb7YGWqViEw9rr05w9Ec7wk72xcJ\/BGH9+WVCKd5iunYL\/4ArAgBkeSMvZMYwaDfvjV2bJCI46ksrdKgKy0sen5mPKo\/B6EKmeHyupOiGON1yHa5p8dRmWgRfLUTI2npjKb1vIxg='
}
```
error
```javascript
{
  status: 'failed',
  errormsg: 'xxxxx'
}
```

示例：
```html
http://adpwechat.samesamechina.com/wechat/retrieve/access_token/XKXM9LKQYFAPKH48
```
### KEY：##### <font color=red>key: XKXM9LKQYFAPKH48</font>
##### <font color=red>iv: V7CWL7T9YOYHH21G</font>
<div class="page-break"></div>## 加密解密方式：

##### 加密方式采用AES-128-CBC＋base64_encode双层加密的方式

##### 解密先用base64_decode 再用AES-128-CBC方式解密

当正确调用接口后会返回一段字符串，先用base64_decode然后再用AES-128-CBC方式解密

##### 加密：```htmlaccess_token = CZe5tguRlkaE6gXbt8ZNcTg2rz2cRMNzvEt86qFIQu2qss9UxTm99rhDB7rqEOUu4A0pnnsmhHvk-6EHbAcXOKmYXhrpqXQvLoFCScRXKTQLEUiACAZSI

string = base64_encode(aes128_cbc_encrypt(access_token))

string: 69rymTHJs2XATXmmSFWNblyCvFdRc2BWYhsRb7YGWqViEw9rr05w9Ec7wk72xcJ/BGH9+WVCKd5iunYL/4ArAgBkeSMvZMYwaDfvjV2bJCI46ksrdKgKy0sen5mPKo/B6EKmeHyupOiGON1yHa5p8dRmWgRfLUTI2npjKb1vIxg=
```
#### 解密：
```html
access_token = base64_decode(aes128_cbc_decrypt(string))

access_token: CZe5tguRlkaE6gXbt8ZNcTg2rz2cRMNzvEt86qFIQu2qss9UxTm99rhDB7rqEOUu4A0pnnsmhHvk-6EHbAcXOKmYXhrpqXQvLoFCScRXKTQLEUiACAZSI
```
