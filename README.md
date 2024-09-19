# Rese（飲食店予約サービス）
<img width="1437" alt="shop_all" src="https://github.com/user-attachments/assets/d8527edc-0c5f-4b47-b6bd-95de4a726716">

## 作成目的
飲食店予約サービスの自社運用のため

## アプリケーションURL
http://43.207.34.5/

・管理者ユーザーアカウントを１件登録済みなので、下記のメールアドレスとパスワードにてログインできます。</br>
 　ユーザー名　　：上岡 純　様</br>
 　メールアドレス：test@example.com</br>
 　パスワード　　：password</br>

## 機能一覧
### ユーザー認証機能
 ・会員登録機能</br>
 ・会員登録時メール認証機能</br>
 ・ログイン機能</br>
 ・ログアウト機能</br>

### 飲食店情報確認機能
 ・飲食店一覧ページ表示</br>
 ・飲食店詳細ページ表示</br>
 ・飲食店検索機能</br>
 ・飲食店ソート機能</br>

### 利用者ユーザー用機能
 ・飲食店お気に入り登録機能</br>
 ・飲食店予約機能</br>
 ・飲食店予約変更機能</br>
 ・飲食店予約削除機能</br>
 ・事前決済機能</br>
 　予約時に事前決済を選択すると、Stripeを利用して決済をすることができます。</br>
 ・予約リマインダーメール機能</br>
 　予約当日の8:00にリマインダーメールが送信されます。</br>
 ・予約照会QRコード機能</br>
 　リマインダーメールにQRコードが添付されます。</br>
 　各ユーザーはQRコードを読み取り予約情報を確認できます。</br>
 ・利用済み店舗レビュー投稿、編集、削除機能</br>

### 管理者ユーザー用機能
 ・店舗代表者作成機能</br>
 ・利用者ユーザーレビュー削除機能</br>

### 店舗代表者ユーザー用機能
 ・新規店舗情報作成機能</br>
 　新規店舗の担当者としてユーザー登録されると、店舗情報を作成・登録することができます。</br>
 ・担当店舗情報編集機能</br>
 　担当店舗を持つ店舗代表者は、店舗情報の一部を編集・更新することができます。</br>
 ・担当店舗予約情報確認機能</br>

### 管理者・店舗代表者ユーザー共通機能
 ・メール送信機能</br>
 　利用者ユーザー一覧ページから送信先を選択し、お知らせメールを送信できます。</br>
 ・利用者ユーザー検索機能</br>

## 使用技術
フレームワーク：Laravel 8.83</br>
プログラミング言語：PHP 8.1</br>
Webサーバー：Nginx 1.21</br>
データベースエンジン：MySQL 8.0</br>
コンテナサービス：Docker 25.0</br>
　　　　　　　　　DockerCompose 2.29</br>
アプリケーションサーバー：AWS EC2</br>
データベース：AWS RDS</br>
ストレージ：AWS S3</br>

## テーブル設計
![スクリーンショット 2024-08-15 161451](https://github.com/user-attachments/assets/2f241697-f7ab-42b7-a686-b49f77bc0303)
![スクリーンショット 2024-08-15 161511](https://github.com/user-attachments/assets/4016db3a-e050-4f2c-8075-9860afc81791)

## ER図
![スクリーンショット 2024-08-15 161921](https://github.com/user-attachments/assets/625e8c5f-56c2-42b5-843d-0618bb49dbc1)

## 環境構築
### 事前準備
※極力シンプルな構築方法を記載します。要件に合わない部分等があれば調整をお願いします。</br>
※AWSの設定については変更等の必要な項目のみ記載しています。記載以外の項目についてはデフォルトで指定されている内容で設定できます。</br>
#### EC2インスタンス作成
1. EC2ダッシュボードで右上のリージョンを東京に設定し、インスタンスを起動をクリック
2. EC2インスタンス名を設定
3. AmazonマシンイメージをAmazon Linux 2 AMIに変更
4. 新しいキーペアを作成し、作成したキーペアを選択</br>
   キーペアを作成するとpemファイルがダウンロードされます。</br>
   このファイルはEC2インスタンスへのリモート接続に使用します。
5. セキュリティグループを作成</br>
   インターネットからのHTTPトラフィックを許可にチェックを入れてください。
6. インスタンスを起動ボタンをクリック
7. インスタンスの一覧ページで作成したインスタンスのボックスにチェックを入れ、表示されるパブリックIPv4アドレスをメモしてください。環境変数の設定で必要になります。
#### RDSデータベース作成
1. RDSダッシュボードで右上のリージョンを東京に設定し、データベースの作成をクリック
2. エンジンのタイプでMySQLを選択
3. エンジンバージョンでMySQL 8.0.39を選択
4. テンプレートを無料利用枠に変更
5. 認証情報管理でセルフマネージドを選択し、パスワードを自動生成にチェック
6. コンピューティングリソースの接続で、EC2コンピューティングリソースに接続を選択し、作成したEC2インスタンスを選択
7. DBサブネットグループで、自動セットアップを選択
8. VPCセキュリティグループで、新規作成を選択
9. 追加設定のトグルを開き、最初のデータベース名を設定
10. データベースの作成ボタンをクリック</br>
    作成に数分かかります。
11. データベースのステータスが利用可能になったら、接続の詳細の表示をクリック
12. 表示されるマスターユーザー名、マスターパスワード、エンドポイントと、設定したデータベース名をメモしてください。環境変数の設定で必要になります。
#### S3バケット作成
1. S3のトップページで右上のリージョンを東京に設定し、バケットを作成をクリック
2. バケット名を設定
3. バケットを作成ボタンをクリック
4. バケット一覧から、作成したバケット名をクリック
5. フォルダの作成をクリック
6. フォルダ名を[images]と設定
7. フォルダの作成ボタンをクリック
8. 作成されたimages/フォルダをクリック
9. アップロードボタンをクリック
10. 既存店舗分のイメージ画像ファイルをドラッグアンドドロップし、アップロードボタンをクリック
11. 設定したバケット名をメモしてください。環境変数の設定で必要になります。
#### IAMユーザーとポリシーの設定
1. IAMダッシュボードサイドバーのアクセス管理->ポリシーをクリック
2. ポリシーの作成をクリック
3. ポリシーエディタのJSONを選択し、デフォルトのコードを削除し以下のように編集してください。
   ![スクリーンショット 2024-08-16 003758](https://github.com/user-attachments/assets/9f4d4d9b-ca9b-46fd-b54d-b1089685bf91)</br>
   ※[your-bucket-name]の部分は作成したバケットのバケット名に書き換えてください。
4. 次へをクリックし、ポリシー名を設定しポリシーの作成ボタンをクリック
5. IAMダッシュボードサイドバーのアクセス管理->ユーザーをクリック
6. ユーザーの作成をクリックし、ユーザー名を設定し次へをクリック</br>
   ※新規にユーザーを作成せずに、既存の任意のユーザー名をクリックし、許可を追加を選択してもOKです。
7. 許可のオプションの、ポリシーを直接アタッチするを選択
8. 作成したポリシー名で検索し、ポリシーを選択し次へをクリック
9. 確認画面で許可を追加をクリック
10. ポリシーを追加後、ユーザー一覧から作成したユーザー名をクリック
11. セキュリティ認証情報タブをクリックし、アクセスキーを作成をクリック
12. AWSコンピューティングサービスで実行されるアプリケーションを選択し、次へをクリック
13. アクセスキー作成後、アクセスキーとシークレットアクセスキーが表示されるのでメモしてください。環境変数の設定で必要になります。
#### メールサーバーの設定
任意のメール用サーバーを選択します。</br>
環境変数の設定で、メールサーバーのパスワードが必要になります。</br>
下記には例として、Gmailアドレスを使用してサーバーとして利用する手順を記載します。</br>

1. GoogleのトップからGoogleアカウントアイコンをクリックし、Googleアカウントを管理をクリック
2. サイドバーのセキュリティをクリック->2段階認証プロセスをクリックし、画面に従って有効にする
3. アプリパスワードをクリック
4. アプリ名を入力し、作成をクリック
5. 16文字のアプリパスワードが表示されるのでメモしてください。
#### Stripeアカウント作成
Stripeのアカウントが無ければ以下のURLからアクセスし、画面に従って作成してください。</br>
https://stripe.com/jp</br>

ログイン後、ホーム画面の[Stripeを使ってみる]の中の公開可能キー、シークレットキーをクリックしてコピーアンドペーストしメモしてください。環境変数の設定で必要になります。
### サーバーソフトインストール・設定
#### EC2インスタンスに接続
1. EC2ダッシュボードから、インスタンス（実行中）をクリック
2. 作成したEC2インスタンスにチェックを入れ、接続をクリックし、SSHクライアントを表示させておく
3. PCのコマンドラインから、以下のコマンドを実行<br/>
   `cd`<br>
   `mkdir ~/.ssh`　※すでに.sshディレクトリが存在する場合はこのコマンドは不要です。</br>
   `mv Downloads/〇〇〇〇.pem .ssh/`</br>
   `cd .ssh/`</br>
   `ls`　※作成したキーペアのpemファイルが存在するか確認してください。</br>
4. キーペアの権限設定</br>
   `chmod 400 "〇〇〇〇.pem"`
5. ログイン</br>
   表示させていたEC2のSSHクライアントから以下のようなコマンドをコピーアンドペーストし、実行します。</br>
   `ssh -i "〇〇〇〇.pem" ec2-user@ec2-??-???-???-???.ap-northeast-1.compute.amazonaws.com`</br>
   最初のログインの際には(yes/no/[fingerprint])?と表示されるので、yesと入力しENTERを押します。
#### Gitインストール・設定
1. Gitインストール</br>
   `sudo yum update -y`</br>
   `sudo yum -y install git`</br>
2. EC2とGitアカウントを紐づけ</br>
   `git config --global user.name "fujiwara-takeshi"`</br>
   `git config --global user.email tfdxvjiyre75528@gmail.com`</br>
#### プロジェクトをクローン
　　`git clone https://github.com/fujiwara-takeshi/20240513_fujiwara_Rese.git`</br>
#### Dockerインストール・設定
　　`sudo amazon-linux-extras install docker -y`</br>
　　`sudo systemctl start docker`</br>
　　`sudo systemctl enable docker`</br>
　　`sudo usermod -aG docker ec2-user`</br>
　　`exit`</br>
設定を反映させるために一度EC2からログアウトし、再ログインしてください。
#### Docker Composeインストール・設定
1. Docker Composeをインストール（以下、1行のコマンドになります）</br>
 `sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose`</br>
2. 実行権限設定</br>
 `sudo chmod +x /usr/local/bin/docker-compose`
#### Dockerコンテナのビルド・起動
　`cd 20240513_fujiwara_Rese/`</br>
　`docker-compose up -d --build`
#### Lavarelパッケージインストール
　`docker-compose exec php bash`</br>
　`composer update`</br>
　`composer install`</br>
　`exit`
#### 環境変数の設定
　`cd src/`</br>
　`cp .env.example .env`</br>
　`vim .env`</br>
vimで.envファイルの編集ができるので、iキーを押してINSERTモードにして以下の箇所を変更してください。</br>
※MAILの設定はGmailをサーバーとして利用する場合の設定を記載します。他のメールサーバーを使用する場合は適宜変更してください。</br>
　`APP_URL=http://EC2インスタンスのIPv4アドレス`</br>
 
　`DB_HOST=RDSエンドポイント`</br>
　`DB_DATABASE=RDSデータベース名`</br>
　`DB_USERNAME=admin`</br>
　`DB_PASSWORD=RDSマスターパスワード`</br>
 
　`MAIL_HOST=smtp.gmail.com`</br>
　`MAIL_PORT=587`</br>
　`MAIL_USERNAME=使用するメールアドレス`</br>
　`MAIL_PASSWORD=Gmailアプリパスワード`</br>
　`MAIL_ENCRYPTION=tls`</br>
 
　`AWS_ACCESS_KEY_ID=IAMユーザーアクセスキー`</br>
　`AWS_SECRET_ACCESS_KEY=IAMユーザーシークレットアクセスキー`</br>
　`AWS_DEFAULT_REGION=ap-northeast-1`</br>
　`AWS_BUCKET=S3バケット名`</br>
 
　`STRIPE_PUBLIC_KEY=Stripeアカウント公開可能キー`</br>
　`STRIPE_SECRET_KEY=Stripeアカウントシークレットキー`</br>
 
編集が終わったらESCキーを押し、`:wq`と入力しENTERを押してください。vimがファイルを保存して終了します。
#### アプリケーションキーの作成
　`cd ../`</br>
　`docker-compose exec php bash`</br>
　`php artisan key:generate`</br>
#### データベースマイグレーション・シーディング
　`php artisan migrate`</br>
　`php artisan db:seed`</br>
　※上記2つのコマンドを実行すると、Do you really wish to run this command? (yes/no)と表示されるので、yesと入力しENTERを押します。</br>
　`exit`</br>
#### 権限設定
1. `ps aux | grep php`</br>
   上記のコマンドを実行して、`php-fpm: pool www`を実行するユーザーを確認します。</br>
   ![スクリーンショット 2024-08-16 220955](https://github.com/user-attachments/assets/31f6db4f-c995-487e-8d5b-7954d17740c9)</br>
   上記の結果の例では、33というユーザー名がそれにあたります。</br>
2. 以下のコマンドを実行する</br>
   `docker-compose exec php chown -R 確認したユーザー名 storage`</br>
#### 予約リマインダー機能有効化設定
　`cd`</br>
　`crontab -e`</br>
 
Vimで編集するファイルが開くので、iキーを押してINSERTモードにして以下のように記述してください。（以下、1行のコマンドになります）</br>
`* * * * * cd /home/ec2-user/20240513_fujiwara_Rese && /usr/local/bin/docker-compose exec php php /var/www/artisan schedule:run >> /dev/null 2>&1`</br>

編集が終わったらESCキーを押し、`:wq`と入力しENTERを押してください。vimがファイルを保存して終了します。</br>


以上
　
