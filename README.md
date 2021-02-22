# 欣榮圖書館研習班報名系統

此專案為替欣榮圖書館開發的研習班報名系統，分為前台和後台



## 10-11更新 & DEBUG說明

- 新增後補名額功能。
- 發現Overview模型會將Primary key預設為id，這將與使用者身分證欄位吻合導致判斷為0，已增加該模型的新Primary Key。

- 修改部分敘述。

- 排除法選課條件限制功能頁面跳轉功能修正。

## 10-06更新 & DEBUG說明

- Laravel Framework版本升級：5.1.46--->5.2.45。
- 移除ControllerServiceProvider服務。

- Excel輸出現在改由使用loadView方法取代row方法。
- 統計下載功能現在直接在HEADER處點選。
- 資料庫中，semester_overview(View)欄位id更改為user_id。

- 修正表單重複提交問題。
