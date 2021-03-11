<template>

  <div class="border-t border-gray-100 text-gray-600 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="w-full text-center mx-auto">
      <div class="absolute right-3">
        <form action=""></form>
        <button
          type="button"
          class="border border-indigo-500 bg-indigo-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-indigo-600 focus:outline-none focus:shadow-outline"
        >
          Create Post
        </button>
      </div>
      <div class="container bg-white px-5 py-12 mx-auto">

        <div class="-my-8 divide-y-2 divide-gray-100">
          <a href="/kek">
            <div class="py-8 cursor-pointer flex flex-row md:flex-nowrap hover:bg-gray-100">
              <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col ">
                <span class="font-semibold title-font text-gray-700">Name</span>
                <span
                  class="mt-1 text-gray-500 text-sm">Date</span>
              </div>
              <div class="md:flex-grow flex-col ">
                <h2 class="text-2xl font-medium text-gray-900 title-font mb-2">Title</h2>
                <p class="leading-relaxed">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab iusto numquam
                  reprehenderit voluptatibus! Architecto, expedita maxime reprehenderit sed sunt ullam!r</p>
                <span class="text-indigo-500 inline-flex items-center mt-4">Learn More
                                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5l7 7-7 7"></path>
                                    </svg>
                                </span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CategoryComponent"
}
</script>

<style scoped>

</style>
