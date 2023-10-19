<?php

namespace App\Services\Post;

use App\Models\Posts;
use App\Models\Categories;
use App\Models\Image;
use App\Models\PostDetail;
use Illuminate\Support\Facades\Storage;

class Service
{
   public function store($data, $dataDetail)
   {
      $categories = array();
      if (isset($data['category'])) {
         foreach ($data['category'] as $key => $value) {
            $categories[] = $key;
         }
         unset($data['category']);
      }

      $post = Posts::create($data);

      $dataDetail['post_id'] = $post->id;

      PostDetail::create($dataDetail);

      $post->categories()->attach($categories);
   }

   public function update($data, $dataDetail, $uri)
   {
      $categories = array();
      if (isset($data['category'])) {
         foreach ($data['category'] as $key => $value) {
            $categories[] = $key;
         }

         unset($data['category']);
      }

      $post = Posts::where('url', $uri)->first();
      $post->update($data);

   
      if (isset($dataDetail['content'])) {
         ksort($dataDetail['content']);
         dump($dataDetail['content']);
         foreach ($dataDetail['content'] as $index => $item) {
            if ($item['type'] == 'img') {
               if (!empty($item['img'])) {
                  if (empty($imagelastId)) {
                     $imagelastId = Image::latest('id')->first()->id;
                  }
                  dump($index);
                  foreach ($item['img'] as $key => $image) {
                  $name = $uri . '_' .
                     $imagelastId . '.' .
                        $image->getClientOriginalExtension();
                  $imagePath = Storage::disk('public')->putFileAs('/images', $image, $name);
                  dump([$name, $imagePath, url('storage/' . $imagePath)]);
                  $imagelast = Image::create([
                     'name' => $name,
                  ]);
                  $imagelastId = $imagelast->id;

                     $dataDetail['content'][$index]['value'][$key] = $name;
                  }
                  unset($dataDetail['content'][$index]['img']);
               } else {
                  unset($dataDetail['content'][$index]);
               }
            }
         }
         $dataDetail['content'] = array_values($dataDetail['content']);
         dump($dataDetail['content']);
         $dataDetail['content'] = json_encode($dataDetail['content'], JSON_UNESCAPED_UNICODE);
      }

      PostDetail::where('post_id', $post->id)->update($dataDetail);

      $post->categories()->sync($categories);


   }

   public function index()
   {
      $posts = Posts::where('active', 0)->get();
      return $posts;
   }

   public function show($uri)
   {
      $post = Posts::join('post_detail', 'posts.id', '=', 'post_detail.post_id')
      ->where('url', $uri)->first();
      if (!isset($post)) dd('404');
      $post->content = json_decode($post->content);
      return $post;
   }

   public function edit($uri)
   {
      $post = Posts::join('post_detail', 'posts.id', '=', 'post_detail.post_id')
      ->where('url', $uri)->first();
      if (!isset($post)) dd('404');
      $categories = Categories::all();

      foreach ($categories as $key => $category) {
         $categories[$key]['checked'] = '';
         foreach ($post->categories as $postCategory) {

            if ($category->id == $postCategory->id) {
               $categories[$key]['checked'] = ' checked';
            }
         }
      }

      $post['categories'] = $categories;
      return $post;
   }

   public function destroy($uri)
   {
      $post = Posts::where('url', $uri)->first();
      $post->delete();

      PostDetail::where('post_id', $post->id)->delete();
   }
}
