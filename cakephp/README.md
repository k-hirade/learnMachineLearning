1. cakephpの下のディクレトリに移動
cd cakephp
2. 事前にdockerをinstallし以下を打つ
docker-compose up -d
sed -i -e "s/Configure::write('Security.salt', '.*');/ Configure::write('Security.salt', 'password');/g" ./app/Config/core.php
sed -i -e "s/Configure::write('Security.cipherSeed', '.*');/ Configure::write('Security.cipherSeed', '0123456789');/g" ./app/Config/core.php
3. dockerの中に入りmysqlを動かす（今後時々この作業が必要）
docker exec -it beginner_cakephp bash
/etc/init.d/mysql start
4. dockerから外に出る
exit
5. dockerにデータをimportする(空のpostsテーブル、itemsテーブル、usersテーブルを作成しています)
docker cp dump.sql beginner_cakephp:/
docker exec -it beginner_cakephp bash -c 'mysql -f -u test -ppassword test < /dump.sql'
docker exec -it beginner_cakephp bash -c 'mysql -f -u test -ppassword test < /dump.sql'
6. localhostにアクセスしてみてください。その次にlocalhost/postsにアクセスしてみてください。エラーがでていなければokです。
7. 今後DB内を触るときの手順
docker exec -it beginner_cakephp bash
mysql -u test -p
パスワードを求められるので、"password"と入力
> show databases;
> use test;
> show tables;
こんな感じです。