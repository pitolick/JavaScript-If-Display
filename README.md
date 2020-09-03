# JavaScript-If-Display
投稿や固定ページなどのコンテンツの一部を特定条件下に表示・非表示を切り替えるショートコードを追加します。

# 特徴
Shifterのようなサーバレス環境での動作を想定しているためJavaScriptを使用して表示・非表示を切り替えています。
表示 or 非表示を判定するだけの簡単な機能ですが、正規表現と1ページ中の複数使用をサポートしています。

# インストール
## プラグインとしてインストール
zipでこのプラグインをダウンロードし、WordPressの管理画面にアップロードしてください。
## テーマファイルに直接記入
`functions.php`に`index.php`内のプラグイン用のメタ情報を除いたソースコードをコピー&ペーストしてください。

# 使い方
以下の囲み型のショートコードを投稿や固定ページ内に追記します。
```
[js_if_display pattern="/hoge/" get="hoge" cookie="hoge" session_storage="hoge" local_storage="hoge"]content[/js_if_display]
```
## 動作説明
ショートコードで囲んだコンテンツを`<div>`で囲み、一意のIDを付与します。
その下に表示・非表示を切り替えるためのJavaScriptを追加します。
ショートコードの引数で指定した参照元の値と正規表現を`macth`メソッドを利用し比較します。
参照元となる値が複数ある場合は、いずれかの値が`macth`メソッドでの比較で`true`となったときにコンテンツを表示させるOR条件での動作となっています。

# 依存関係
JavaScriptを使用して記述しているため、jQueryが無い環境でも動作します。
閲覧に使用するブラウザがJavaScriptをサポートしていれば動作します。

## 引数
| 引数名 | 条件 | 説明 |
----|----|----
| pattern | 必須 | `match`メソッドで使用するためのデリミタを含んだ正規表現パターンを指定。 |
| get | 任意※ | クエリパラメータのKeyを指定。 |
| cookie | 任意※ | cookieのKeyを指定。 |
| session_storage | 任意※ | sessionStorageのKeyを指定。 |
| local_storage | 任意※ | localStorageのKeyを指定。 |

※いずれか1つの指定は必須となります。

# 注意
- サーバーレス環境での動作を想定しているため、SESSIONを参照する機能は搭載していません。
- ショートコードで囲んだコンテンツを`<div>`で囲むため、使用しているテーマによってはスタイルが崩れる可能性があります。
- 必須となっている引数を指定しない場合、エラーとなり他のJavaScriptに干渉する可能性があります。