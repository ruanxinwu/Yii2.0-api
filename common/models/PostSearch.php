<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;

/**
 * PostSearch represents the model behind the search form of `common\models\Post`.
 */
class PostSearch extends Post
{
    // 给该类添加一个属性
    public function attributes()
    {
        return array_merge(parent::attributes(),['authorName']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title', 'content', 'taggs','authorName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            // 获取数据
            'query' => $query,

            // 分页
            'pagination' => ['pageSize' => 2],// 每页两条数据

            // 排序,默认用id为倒序排列
            'sort' => [
                'defaultOrder' => [
                    //'id' => SORT_DESC
                ],

                //表示只能用 id 和 title 两字段排序（数据库里的字段,对应新加的属性不好使）
                'attributes' => ['id','title']
            ]
        ]);

        // 块赋值，把表单中的填写的数值赋值给当前对象的属性
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             //$query->where('0=1');字段通不过验证时是否展示数据
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'post.id' => $this->id,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'taggs', $this->taggs]);

        // 使用inner join 连接表 adminuser 条件：post_author_id = adminuser.id
        $query->join('Inner JOIN','admin_user','post.author_id = admin_user.id');
        $query->andFilterWhere(['like', 'adminuser.nickname', $this->authorName]);


//        $dataProvider->sort->attributes['authorName'] =
//            [
//                'asc' => ['adminuser.nickname' => SORT_DESC],
//                'desc' => ['Adminuser.nickname' => SORT_ASC],

//                'status' => SORT_ASC,
//                'id' => SORT_DESC
//            ];
        return $dataProvider;
    }
}
