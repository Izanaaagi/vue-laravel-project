<template>
  <div v-if="CURRENT_TOPIC.user" class="p-8 dark:bg-gray-900 flex items-center ">
    <div class="px-5 py-4 bg-white dark:bg-gray-800 shadow rounded-lg w-full">
      <div class="flex mb-4">
        <img width="200px" class="w-12 h-12 rounded-full"
             :src="CURRENT_TOPIC.user.avatar_path"
             alt="">
        <div class="ml-2 mt-0.5">
                    <span
                      class="block font-medium text-base leading-snug text-black dark:text-gray-100">{{
                        CURRENT_TOPIC.user.name
                      }}</span>
          <span
            class="block text-sm text-gray-500 dark:text-gray-400 font-light leading-snug">{{
              CURRENT_TOPIC.created_at
            }}</span>
        </div>
      </div>
      <h2 class="font-bold text-lg h-2 mb-8">{{ CURRENT_TOPIC.title }}</h2>
      <p class="text-gray-800 dark:text-gray-100 leading-snug md:leading-normal">{{ CURRENT_TOPIC.text }}</p>
      <div class="flex justify-between items-center mt-5">
        <div class="flex ">
          <button>
            <svg viewBox="0 0 20 20"
                 class="text-gray-500 hover:text-green-600 mr-1 w-5">
              <g id="Page-1" stroke="none" stroke-width="1" fill="none"
              >
                <g class="fill-current">
                  <path
                    d="M11.0010436,0 C9.89589787,0 9.00000024,0.886706352 9.0000002,1.99810135 L9,8 L1.9973917,8 C0.894262725,8 0,8.88772964 0,10 L0,12 L2.29663334,18.1243554 C2.68509206,19.1602453 3.90195042,20 5.00853025,20 L12.9914698,20 C14.1007504,20 15,19.1125667 15,18.000385 L15,10 L12,3 L12,0 L11.0010436,0 L11.0010436,0 Z M17,10 L20,10 L20,20 L17,20 L17,10 L17,10 Z"
                    id="Fill-97"></path>
                </g>
              </g>
            </svg>
          </button>
          <span class=" ml-1 text-gray-500 dark:text-gray-400 font-light">{{ CURRENT_TOPIC.likes }}</span>
          <button class="ml-5">
            <svg viewBox="0 0 20 20" class="text-gray-500 hover:text-red-600 mr-1 w-5">
              <g id="Page-1" stroke="none" stroke-width="1" fill="none">
                <g class="fill-current">
                  <path
                    d="M11.0010436,20 C9.89589787,20 9.00000024,19.1132936 9.0000002,18.0018986 L9,12 L1.9973917,12 C0.894262725,12 0,11.1122704 0,10 L0,8 L2.29663334,1.87564456 C2.68509206,0.839754676 3.90195042,8.52651283e-14 5.00853025,8.52651283e-14 L12.9914698,8.52651283e-14 C14.1007504,8.52651283e-14 15,0.88743329 15,1.99961498 L15,10 L12,17 L12,20 L11.0010436,20 L11.0010436,20 Z M17,10 L20,10 L20,0 L17,0 L17,10 L17,10 Z"
                    id="Fill-97"></path>
                </g>
              </g>
            </svg>
          </button>
          <span
            class="ml-1 text-gray-500 dark:text-gray-400  font-light"><span
            class="ml-1 text-gray-500 dark:text-gray-400  font-light">{{ CURRENT_TOPIC.dislikes }}</span></span>
        </div>
        <div class="flex flex-row ml-1 text-gray-500 dark:text-gray-400 font-light">
          <div>11 comments</div>
          <!--          @if(auth()->id() == $topic->user_id)-->
          <!--          <form class="ml-5"-->
          <!--                action="{{route('deleteTopic', ['topic' => $topic])}}"-->
          <!--                accept-charset="UTF-8"-->
          <!--                method="post">-->
          <!--            @csrf-->
          <!--            @method('DELETE')-->
          <!--            <div class="flex flex-row justify-end">-->
          <!--              <button type="submit"-->
          <!--                      class="outline-none font-bold px-3 py-1 bg-red-600 text-sm hover:bg-red-700 text-white shadow-md rounded ">-->
          <!--                Delete-->
          <!--              </button>-->
          <!--            </div>-->
          <!--          </form>-->
          <!--          @endif-->
        </div>
      </div>
    </div>
  </div>

  <!--  <div class="px-8 pb-8 dark:bg-gray-900 flex items-center ">-->

  <!--    <section class="rounded-b-lg w-full  mt-4 ">-->

  <!--      <div id="task-comments" class="pt-4">-->
  <!--        @foreach($topic->comments()->get() as $comment)-->
  <!--        <div-->
  <!--          class="bg-white rounded-lg p-3  flex flex-col justify-center items-center md:items-start shadow-lg mb-4">-->
  <!--          <div class="flex flex-row justify-center mr-2 w-full">-->
  <!--            @if($comment->user()->isProfilePhoto())-->
  <!--            <img width="48" height="48"-->
  <!--                 class="rounded-full w-10 h-10 mr-4 shadow-lg mb-4"-->
  <!--                 src="{{$comment->user()->getProfilePhotoUrlAttribute()}}">-->
  <!--            @else <img width="48" height="48"-->
  <!--                       class="rounded-full w-10 h-10 mr-4 shadow-lg mb-4"-->
  <!--                       src="/storage/profile-photos/default-avatar.jpg"-->
  <!--                       alt="">-->
  <!--            @endif-->
  <!--            <div class="flex flex-row justify-between w-full">-->
  <!--              <h3 class="text-purple-600 font-semibold text-lg text-center md:text-left ">-->
  <!--                {{ $comment->user()->name }}</h3>-->
  <!--              <span-->
  <!--                class="text-gray-500">{{ date("Y-m-d H:i:s", strtotime($comment->created_at)) }}</span>-->
  <!--            </div>-->
  <!--          </div>-->


  <!--          <p style="width: 90%"-->
  <!--             class="text-gray-600 text-lg text-center md:text-left ">{{ $comment->text }}</p>-->
  <!--          @if(auth()->id() == $comment->user_id)-->
  <!--          <form class="w-full"-->
  <!--                action="{{route('deleteTopicComment', ['topic' => $topic, 'comment' => $comment])}}"-->
  <!--                accept-charset="UTF-8"-->
  <!--                method="post">-->
  <!--            @csrf-->
  <!--            @method('DELETE')-->
  <!--            <div class="flex flex-row justify-end">-->
  <!--              <button type="submit"-->
  <!--                      class="outline-none font-bold px-2 bg-red-600 text-sm hover:bg-red-700 text-white shadow-md rounded-lg ">-->
  <!--                Delete-->
  <!--              </button>-->
  <!--            </div>-->
  <!--          </form>-->
  <!--          @endif-->
  <!--        </div>-->
  <!--        @endforeach-->

  <!--        <form action="{{route('topicComment', compact('topic'))}}" accept-charset="UTF-8" method="post"><input-->
  <!--          type="hidden">-->
  <!--          @csrf-->
  <!--          <textarea-->
  <!--            class="resize-none w-full shadow-inner p-4 border-0 mb-4 rounded-lg focus:shadow-outline text-2xl"-->
  <!--            placeholder="Ask questions here." cols="6" rows="4" id="comment_content"-->
  <!--            name="text" spellcheck="false"></textarea>-->
  <!--          <button type="submit"-->
  <!--                  class="font-bold py-2 px-4 w-full bg-indigo-600 text-lg hover:bg-indigo-700 text-white shadow-md rounded-lg ">-->
  <!--            Comment-->
  <!--          </button>-->
  <!--        </form>-->
  <!--      </div>-->
  <!--    </section>-->

  <!--  </div>-->


</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
  name: "TopicComponent",
  data() {
    return {
      categoryId: this.$route.params.category,
      topicId: this.$route.params.topic
    }
  },
  methods: {
    ...mapActions(['GET_TOPIC_BY_ID'])
  },
  computed: {
    ...mapGetters(['CURRENT_TOPIC'])
  },
  mounted() {
    this.GET_TOPIC_BY_ID({categoryId: this.categoryId, topicId: this.topicId})
  }
}
</script>

<style scoped>
button {
  outline: none;
}
</style>
