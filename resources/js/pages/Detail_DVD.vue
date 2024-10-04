<template>
  <div class="detail-area">

    <div class="detail-show-area">
      <!-- タイトル -->
      <div class="detail-show-title">{{ DVD.title }}</div>

      <!-- 諸々情報 -->
      <div class="detail-show-info-area">
        <div class="detail-show-info-line">
          <div class="detail-show-info-block">
            <div class="detail-show-info-header" v-if="DVD.category">
              {{ optionCategories[optionCategories.findIndex(({value}) => value == DVD.category)].title }}
            </div>
          </div>

          <div class="detail-show-info-block">
            <div class="detail-show-info-header">媒体:</div>
            <div class="detail-show-info-header" v-if="DVD.format == 1">DVD</div>
            <div class="detail-show-info-header" v-else>Bluray</div>
          </div>

          <div class="detail-show-info-block">
            <div class="detail-show-info-header">特典:</div>
            <div class="detail-show-info-header" v-if="DVD.special"><i class="fas fa-check fa-fw"></i></div>
            <div class="detail-show-info-header" v-else><i class="fas fa-times"></i></div>
          </div>

          <div class="detail-show-info-block">
            <div class="detail-show-info-header">貸出可否:</div>
            <div class="detail-show-info-header green" v-if="!rentFlag"><i class="far fa-circle"></i></div>
            <div class="detail-show-info-header red" v-else><i class="fas fa-times"></i></div>
          </div> 
        </div>

        <div class="detail-show-info-line" v-if="DVD.url_DVD">
          <div class="detail-show-info-block detail-show-other-flex">
            <div class="detail-show-info-header detail-show-other-width">イーオシ:</div>
            <a :href="DVD.url_DVD" class="detail-show-info-header" target="_blank" rel="noopener noreferrer">{{ DVD.url_DVD }}</a>
          </div>
        </div>

        <div class="detail-show-info-line" v-if="DVD.url_movie">
          <div class="detail-show-info-block detail-show-other-flex">
            <div class="detail-show-info-header detail-show-other-width">ゲキ×シネ:</div>
            <a :href="DVD.url_movie" class="detail-show-info-header" target="_blank" rel="noopener noreferrer">{{ DVD.url_movie }}</a>
          </div>
        </div>

        <div class="detail-show-info-line" v-if="DVD.url_youtube">
          <div class="detail-show-info-block detail-show-other-flex">
            <div class="detail-show-info-header detail-show-other-width">映像:</div>
            <a :href="DVD.url_youtube" class="detail-show-info-header" target="_blank" rel="noopener noreferrer">{{ DVD.url_youtube }}</a>
          </div>
        </div>
      </div>

      <!-- 写真 -->
      <div v-if="DVD.photos.length" class="detail-show-photo-grid-box">
        <div v-for="(photo, index) in DVD.photos" class="detail-show-photo-grid-block">
          <div class="detail-show-photo-grid-photo">
            <figure v-if="photo.url" class="detail-show-photo-grid-photo-wrapper">
              <img
                class="detail-show-photo-grid-photo-image"
                :src="photo.url"
                :alt="index"
              >
              <input type="button" class="detail-show-photo-button" @click="openModal_photo(photo.url)">
            </figure>
          </div>
        </div>
      </div>

      <!-- 公演期間 -->
      <div class="detail-show-duration-area detail-show-other-flex" v-if="DVD.duration_from">
        <div class="detail-show-header detail-show-other-width">公演期間</div>
        <div class="detail-show-duration">
          <div class="detail-show-duration-content" v-if="DVD.duration_from">{{ DVD.duration_from }}</div>
          <div class="detail-show-duration-content" v-if="DVD.duration_to">~</div>
          <div class="detail-show-duration-content" v-if="DVD.duration_to">{{ DVD.duration_to }}</div>
        </div>
      </div>

      <!-- 公演地 -->
      <div class="detail-show-locations-area detail-show-other-flex" v-if="DVD.locations.length">
        <div class="detail-show-header">公演地</div>
        <div class="detail-show-locations-block detail-show-other-width">
          <div class="detail-show-location-area detail-show-other-width" v-for="location in DVD.locations">
            <div class="detail-show-location-content">{{ location.theater }}</div>
            <div class="detail-show-location-content-small" v-if="location.prefecture">
              (@{{ optionPrefectures[optionPrefectures.findIndex(({value}) => value == location.prefecture)].title }})
            </div>
          </div>
        </div>
      </div>

      <!-- 戯曲 -->
      <div class="detail-show-author-area" v-if="DVD.author">
        <div class="detail-show-header">戯曲</div>
        <div class="detail-show-author">{{ DVD.author }}</div>
      </div>

      <!-- 衣装 -->
      <div class="detail-show-author-area" v-if="DVD.costumers.length">
        <div class="detail-show-header">衣装</div>
        <div class="detail-show-costumers-block">
          <div class="detail-show-costumer-area" v-for="costumer in DVD.costumers">
            <div class="detail-show-author">{{ costumer.name }}</div>
          </div>
        </div>
      </div>

      <!-- 作詞 -->
      <div class="detail-show-author-area" v-if="DVD.lyricist">
        <div class="detail-show-header">衣装</div>
        <div class="detail-show-author">{{ DVD.lyricist }}</div>
      </div>

      <!-- 振付 -->
      <div class="detail-show-author-area" v-if="DVD.choreo">
        <div class="detail-show-header">振付</div>
        <div class="detail-show-author">{{ DVD.choreo }}</div>
      </div>

      <!-- ゲキ×シネ監督 -->
      <div class="detail-show-author-area" v-if="DVD.director">
        <div class="detail-show-header">ゲキ×シネ監督</div>
        <div class="detail-show-author">{{ DVD.director }}</div>
      </div>

      <!-- あらすじ -->
      <div class="detail-show-story-area detail-show-other-flex" v-if="DVD.story">
        <div class="detail-show-header detail-show-other-width">あらすじ</div>
        <div class="detail-show-story detail-show-other-width">{{ DVD.story }}</div>
      </div>

      <!-- 配役 -->
      <div class="detail-show-roles-area detail-show-other-flex" v-if="DVD.roles.length">
        <div class="detail-show-header">配役</div>
        <div class="detail-show-roles-block detail-show-other-width">
          <div class="detail-show-role-area" v-for="role in DVD.roles">
            <div class="detail-show-role-role" v-if="role.role">{{ role.role }}:</div>
            <div class="detail-show-role-role" v-else></div>
            <div class="detail-show-role-content" v-if="role.player">{{ role.player }}</div>
          </div>
        </div>
      </div>

      <!-- 感想 -->
      <div class="detail-show-impression-area detail-show-other-flex" v-if="DVD.impression">
        <div class="detail-show-header">感想</div>
        <div class="detail-show-impression detail-show-other-width">{{ DVD.impression }}</div>
      </div>

      <!-- 役感想 -->
      <div class="detail-show-role-impressions-area" v-if="DVD.roleImpressionList.length">
        <div class="detail-show-role-impression-block" v-for="roleImpression in DVD.roleImpressionList">
          <div class="detail-show-role-impression-area">
            <div class="detail-show-role-impression-detail-area">
              <div ref="detail_show_role_impression_headers">【{{ roleImpression.role }} <span><span class="detail-show-role-impression-detail-small">(by {{ roleImpression.player }})</span>】</span></div>
              <div class="detail-show-role-impression-detail-impression">{{ roleImpression.impression }}</div>
            </div>
            <div class="detail-show-role-impression-photo">
              <figure v-if="roleImpression.photos[0]" class="detail-show-role-impression-photo-wrapper">
                <img
                  class="detail-show-role-impression-photo-image"
                  :src="roleImpression.photos[0].url"
                  :alt="roleImpression.role"
                >
                <input type="button" class="detail-show-photo-button" @click="openModal_photo(roleImpression.photos[0].url)">
              </figure>
            </div>
          </div>
        </div>
      </div>

      <!-- 歴史 -->
      <div class="detail-show-others-area" v-if="DVD.histories.length">
        <div class="detail-show-header">歴史</div>
        <div class="detail-show-others-block">
          <div v-for="history in DVD.histories" class="detail-show-other-area detail-show-other-flex">
            <div class="detail-show-header detail-show-other-width" v-if="history.title">{{ history.title }}</div>
            <div class="detail-show-other-area detail-show-other-width">{{ history.history }}</div>
          </div>
        </div>
      </div>

      <!-- 歌 -->
      <div class="detail-show-others-area" v-if="DVD.songs.length">
        <div class="detail-show-header">歌</div>
        <div class="detail-show-others-block">
          <div v-for="song in DVD.songs" class="detail-show-song-area">
            <div ref="detail_song_titles" class="detail-show-singer-common detail-show-singer-2">
              <div class="detail-show-singer-common">
                【
              </div>
              <div class="detail-show-singer-common detail-show-singer-5">
                <div class="detail-show-singer-common detail-show-singer-2">
                  {{ song.title }}
                  <div v-if="song.singers.length" class="detail-show-singer-common">/</div>
                </div>

                <div class="detail-show-singer-common detail-show-singer-2">                
                  <div v-if="song.singers.length" class="detail-show-singer-common">
                    <div v-for="(singer, index) in song.singers" class="detail-show-singer-common">
                      <div v-if="singer.role_id" class="detail-show-singer-common detail-show-singer-2">
                        {{ singer.role.role }}
                        <div class="detail-show-singer-small">
                          (by {{ singer.role.player }})
                        </div>
                      </div>
                      <div v-else-if="singer.role_group_id">
                        {{ singer.role_group.name }}
                      </div>
                      <div v-else>
                        {{ singer.name }}
                      </div>

                      <div v-if="index !== song.singers.length - 1">・</div>
                    </div>
                  </div> 
                  <div>】</div> 
                </div>        
              </div>
            </div>
            <div class="detail-show-song-impression" v-if="song.impression">{{ song.impression }}</div>
          </div>
        </div>
      </div>

      <!-- その他 -->
      <div class="detail-show-others-area detail-show-other-flex" v-if="DVD.others.length">
        <div class="detail-show-header detail-show-other-width">その他</div>
        <div class="detail-show-others-block">
          <div v-for="other in DVD.others" class="detail-show-other-area detail-show-other-flex">
            <div class="detail-show-header detail-show-other-width" v-if="other.title">{{ other.title }}</div>
            <div class="detail-show-other-area detail-show-other-width" v-if="other.impression">{{ other.impression }}</div>
          </div>
        </div>
      </div>

    </div>

    <photoDialog :postURL="dialog_url" v-show="showContent_photo" @close="closeModal_photo"/>
  </div>
</template>

<script>
import { OK, UNPROCESSABLE_ENTITY } from '../util'
import photoDialog from '../components/Photo_Dialog.vue'

export default {
  props: {
    propDVD: {
      type: String,
      required: true
    }
  },
  // このページの上で表示するコンポーネント
  components: {
    photoDialog
  },
  // データ
  data() {
    return {
      // 表示するDVDのデータ
      DVD: {},
      // 元データ
      originalDVD: {},
      // 貸出可否
      rentFlag: 0,   
      // エラー
      errors: {
        photo: {
          roleImpression: null,
          pres: null
        },
        error: null,
      },
      
      // photo
      showContent_photo: false,
      dialog_url: '',

      // 都道府県
      optionPrefectures : [
        { title:'北海道', value :1 },
        { title:'青森県', value :2 },
        { title:'岩手県', value :3 },
        { title:'宮城県', value :4 },
        { title:'秋田県', value :5 },
        { title:'山形県', value :6 },
        { title:'福島県', value :7 },
        { title:'茨城県', value :8 },
        { title:'栃木県', value :9 },
        { title:'群馬県', value :10 },
        { title:'埼玉県', value :11 },
        { title:'千葉県', value :12 },
        { title:'東京都', value :13 },
        { title:'神奈川県', value :14 },
        { title:'新潟県', value :15 },
        { title:'富山県', value :16 },
        { title:'石川県', value :17 },
        { title:'福井県', value :18 },
        { title:'山梨県', value :19 },
        { title:'長野県', value :20 },
        { title:'岐阜県', value :21 },
        { title:'静岡県', value :22 },
        { title:'愛知県', value :23 },
        { title:'三重県', value :24 },
        { title:'滋賀県', value :25 },
        { title:'京都府', value :26 },
        { title:'大阪府', value :27 },
        { title:'兵庫県', value :28 },
        { title:'奈良県', value :29 },
        { title:'和歌山県', value :30 },
        { title:'鳥取県', value :31 },
        { title:'島根県', value :32 },
        { title:'岡山県', value :33 },
        { title:'広島県', value :34 },
        { title:'山口県', value :35 },
        { title:'徳島県', value :36 },
        { title:'香川県', value :37 },
        { title:'愛媛県', value :38 },
        { title:'高知県', value :39 },
        { title:'福岡県', value :40 },
        { title:'佐賀県', value :41 },
        { title:'長崎県', value :42 },
        { title:'熊本県', value :43 },
        { title:'大分県', value :44 },
        { title:'宮崎県', value :45 },
        { title:'鹿児島県', value :46 },
        { title:'沖縄県', value :47 }],
      members : ['古田新太', '橋本じゅん', '高田聖子', '粟根まこと', '右近健一', '逆木圭一郎', '河野まさと', '村木よし子', 'インディ高橋', '山本カナコ', '礒野慎吾', '吉田メタル', '中谷さとみ', '保坂エマ', 'こぐれ修', '枯暮修', '竹田団吾', '羽野アキ', '羽野晶紀', '杉本恵美', 'タイソン大屋'], // 劇団員
      
      // カテゴリー
      optionCategories: [
        { title: 'いのうえ歌舞伎', value: 1 },
        { title: 'ネタモノ', value: 2 },
        { title: '音もの', value: 3},
        { title: 'その他', value: 4}
      ]
    }
  },
  watch: {
    propDVD: {
      async handler(propDVD) {
        if(this.propDVD){
          await this.fetchDVD();
        }        
      },
      immediate: true,
    }
  },
  methods: {
    // DVDの詳細を取得
    async fetchDVD () {
      const response = await axios.get('/api/DVD/'+ this.propDVD);

      if (response.status !== 200) {
        this.$store.commit('error/setCode', response.status);
        return false;
      }

      this.DVD = response.data;
      let count = 0;
      this.DVD.roles.forEach(role => {
        if(role.impression){
          if(!this.DVD.roleImpressionList) {
            this.DVD.roleImpressionList = [];
          }
          this.DVD.roleImpressionList[count] = new Object();
          const newRoleImpression = {role_id: role.id, order: role.order, role: role.role, player: role.player, impression: role.impression, photos: role.role_photos};
          this.DVD.roleImpressionList[count] = newRoleImpression;
          count++;
        }
      });
      if(!this.DVD.roleImpressionList) {
        this.DVD.roleImpressionList = [];
      }
      this.DVD.locations.sort((a, b) => a.order - b.order );
      this.DVD.costumers.sort((a, b) => a.order - b.order );
      this.DVD.roles.sort((a, b) => a.order - b.order );
      this.DVD.roleImpressionList.sort((a, b) => a.order - b.order);
      this.DVD.role_groups.sort((a, b) => a.order - b.order);
      this.DVD.songs.sort((a, b) => a.order - b.order);
      this.DVD.songs.forEach((song) => {
        song.singers.sort((a, b) => a.order - b.order);
      });
      this.DVD.others.sort((a, b) => a.order - b.order);

      this.originalDVD = JSON.parse(JSON.stringify(this.DVD));
      if(this.originalDVD.rents) {
        this.rentFlag = this.DVD.rents.find(rent => rent.flag == 1);
      }

      this,this.showAreaResize();
    },

    // 描写後
    showAreaResize() {
      this.$nextTick(() => {
        const screenWidth = document.documentElement.clientWidth;
        let mainRem = 0;
        if(screenWidth <= 767) {
          mainRem = this.convertRem2Px(2) * 2;
        } else {
          mainRem = this.convertRem2Px(4) * 2;
        }

        // 役感想
        if(this.$refs.detail_show_role_impression_headers) {
          this.$refs.detail_show_role_impression_headers.forEach(header => {
            if(header.clientWidth + mainRem >= screenWidth) {
              header.classList.add('detail-show-role-impression-detail-header');
              header.children[0].classList.add('detail-show-role-impression-detail-player-brackets');
            }
          });
        }        

        // 歌タイトル
        if(this.$refs.detail_song_titles) {
          this.$refs.detail_song_titles.forEach(song => {
            if(song.clientWidth + mainRem >= screenWidth) {
              song.classList.add('detail-show-singer-title-area');
              song.children[1].classList.add('detail-show-singer-column-1');
              song.children[1].children[1].classList.add('detail-show-singer-column-2');
              if(song.children[1].children[1].clientWidth + mainRem >= screenWidth) {
                song.children[1].children[1].children[0].classList.add('detail-show-singer-column-3');
              }
            }
          });
        }
      });
    },

    // remからpx
    convertRem2Px(rem) {
      const fontSize = getComputedStyle(document.documentElement).fontSize;
      return rem * parseFloat(fontSize);
    },

    // 写真拡大
    openModal_photo(url) {
      this.showContent_photo = true;
      this.dialog_url = url;
    },
    closeModal_photo() {
      this.showContent_photo = false;
      this.dialog_url = '';
    }
  }
}
</script>