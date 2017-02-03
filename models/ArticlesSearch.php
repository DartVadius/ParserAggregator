<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Articles;
use app\models\ArticlesToTags;
use app\models\Tags;

/**
 * ArticlesSearch represents the model behind the search form about `app\models\Articles`.
 */
class ArticlesSearch extends Articles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'category_id'], 'integer'],
            [['title', 'text', 'article_create_datetime', 'link_to_article', 'Article_JSON', 'sourse'], 'safe'],
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
        $query = Articles::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'article_id' => $this->article_id,
            'article_create_datetime' => $this->article_create_datetime,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'link_to_article', $this->link_to_article])
            ->andFilterWhere(['like', 'Article_JSON', $this->Article_JSON])
            ->andFilterWhere(['like', 'sourse', $this->sourse]);

        return $dataProvider;
    }

    public function articlesByUserHystory($tags)
    {
        $articles_by_hystory = [];
        foreach ($tags as $tag) {
            $articles = (new \yii\db\Query())
                ->select(['Articles.article_id', 'Articles.title', 'Articles.article_create_datetime', 'Articles.link_to_article'])
                ->from('Articles')
                ->leftJoin('Articles_To_Tags', 'Articles.article_id = Articles_To_Tags.article_id')
                ->leftJoin('Tags', 'Articles_To_Tags.tag_id = Tags.tag_id')
                ->where(['Tags.tag_id' => $tag['tag_id']])
                ->groupBy('Articles.article_id')
                ->orderBy('article_create_datetime desc')
                ->all();

            $articles_by_hystory = array_merge($articles_by_hystory, $articles);
        }
        $articles_by_hystory = array_slice($articles_by_hystory, 0, 10);
        return $articles_by_hystory;
    }
}
