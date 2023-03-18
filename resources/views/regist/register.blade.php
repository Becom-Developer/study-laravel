<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録フォーム</title>
</head>

<body>
  <form action="/register" name="registform" method="post" id="registform">
    {{csrf_field()}}
    <dl>
      <dt>名前:</dt>
      <dd><input type="text" name="name" size="30">
        <span>{{$errors->first('name')}}</span>
      </dd>
      <dt>メールアドレス:</dt>
      <dd><input type="email" name="email" size="30">
        <span>{{$errors->first('email')}}</span>
      </dd>
      <dt>パスワード:</dt>
      <dd><input type="password" name="password" size="30">
        <span>{{$errors->first('password')}}</span>
      </dd>
      <dt>パスワード(確認):</dt>
      <dd><input type="password" name="password_confirmation" size="30">
        <span>{{$errors->first('password_confirmation')}}</span>
      </dd>
      <button type="submit" name="action" value="send">送信</button>
    </dl>
  </form>
</body>

</html>