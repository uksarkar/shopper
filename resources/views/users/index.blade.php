@extends('layouts.app')
@section('title')
    Mange your account
@endsection
@section('content')
      <!-- Start main container -->
      @include('users.sidebar')
      <div class="container mx-auto mt-2 min-h-screen rounded p-2">
        {{-- start row --}}
        <div class="flex justify-between">
          {{-- col one --}}
          <div class="w-5/12 pr-4">
            <div class="bg-white rounded shadow p-4 mb-4">
              You have total {{ count($user->shops) }} shops
            </div>
            <div class="bg-white rounded shadow p-4 mb-4">
              You have total {{ count($user->prices) }} products
            </div>
            <div class="bg-white rounded shadow p-4 mb-4">
              @if(!blank($user->memberships))
              <h4 class="mb-2 border-b border-gray-400">You currently have the following memberships</h4>
                @foreach ($user->memberships as $membership)
                  <p class="mb-4 text-primary-dark">
                    <span>{{ $membership->name }}</span>
                    @switch($membership->request->status)
                        @case(0)
                            <span class="rounded-full ml-2 px-2 bg-orange-600 text-white">Panding</span>
                            @break
                        @case(1)
                            <span class="rounded-full ml-2 px-2 bg-green-800 text-white">activeted</span>
                            @break
                        @default
                            <span class="rounded-full ml-2 px-2 bg-red-800 text-white">Rejacted</span>
                    @endswitch
                  </p>
                @endforeach
              @else 
                <h4>You currently doesn't have any memberships.</h4>
              @endif
            </div>
          </div>
          {{-- end col one --}}
          {{-- start col two --}}
          <div class="w-7/12 ">
            <div class="flex bg-white rounded shadow p-4  ">
              <div class="w-3/4 pr-2">
                <p class="text-right">
                  <button :disabled="showInputs" type="button" @click="showPasswordForm = !showPasswordForm" :class="showPasswordForm ? 'btn-outline-danger':'btn-outline-warning'">
                    <span v-if="!showPasswordForm"><i class="fa fa-user-cog"></i> Change Password</span>
                    <span v-else><i class="fa fa-times"></i> Cancle</span>
                  </button>
                  <button :disabled="showPasswordForm" type="button" @click="showInputs=!showInputs" :class="showInputs ? 'btn-outline-danger':'btn-outline-info'">
                    <span v-if="!showInputs"><i class="fa fa-edit"></i> Edit bio</span>
                    <span v-else><i class="fa fa-times"></i> Cancle</span>
                  </button>
                </p>
                <form v-if="!showPasswordForm" @submit="tabs=2" action="{{ route('home.account.updateBio',$user->id) }}" method="post">
                  @csrf
                  <p class="py-4 px-2 border-b border-gray-400">
                    Name: <span v-if="!showInputs">{{ $user->name }}</span>
                    <input required v-else class="border rounded p-1 focus:bg-info-lighter bg-gray-200 transition-250 border-info-normal text-grey-500" type="text" name="name" value="{{ old('name',$user->name) }}">
                  </p>
                  <p class="py-4 px-2 border-b border-gray-400">
                    Location: <span v-if="!showInputs">{{ $user->location }}</span>
                    <input required v-else class="border rounded p-1 focus:bg-info-lighter bg-gray-200 transition-250 border-info-normal text-grey-500" type="text" name="location" value="{{ old('location',$user->location) }}">
                  </p>
                  <p class="py-4 px-2 border-b border-gray-400">
                    Phone: <span v-if="!showInputs">{{ $user->phone }}</span>
                    <input required v-else class="border rounded p-1 focus:bg-info-lighter bg-gray-200 transition-250 border-info-normal text-grey-500" type="text" name="phone" value="{{ old('phone',$user->phone) }}">
                  </p>
                  <p class="py-4 px-2 border-b border-gray-400">
                    Email: <span v-if="!showInputs">{{ $user->email }}</span>
                    <input required v-else class="border rounded p-1 focus:bg-info-lighter bg-gray-200 transition-250 border-info-normal text-grey-500" type="email" name="email" value="{{ old('name',$user->email) }}">
                    <strong v-if="showInputs" class="block text-xs text-red-500">You have to verify your email if you want change it.</strong>
                  </p>
                  <p class="text-right" v-if="showInputs">
                    <button :disabled="tabs === 2" class="btn-outline-success mt-4" type="submit">
                      <span v-if="tabs !== 2">Update</span>
                      <i v-else class="fa fa-circle-notch fa-spin"></i>
                    </button>
                  </p>
                </form>
                <form @submit="tabs=2" v-else action="{{ route('home.account.changePassword',$user->id) }}" method="post">
                  @csrf
                  <div class="border border-gray-400 p-2 mt-2 rounded">
                    <p class="py-4 px-2">
                      <strong>Current Password: </strong>
                      <input required placeholder="Insert current password" class="border border-gray-400 p-1 rounded focus:outline-none focus:bg-gray-100" type="password" name="current_password">
                    </p>
                    <p class="py-4 px-2">
                      <strong>New Password: </strong>
                      <input required placeholder="Insert new password" class="border border-gray-400 p-1 rounded focus:outline-none focus:bg-gray-100" type="password" name="new_password">
                    </p>
                    <p class="py-4 px-2">
                      <strong>Confirm Password: </strong>
                      <input required placeholder="Confirm new password" class="border border-gray-400 p-1 rounded focus:outline-none focus:bg-gray-100" type="password" name="new_password_confirmation">
                    </p>
                    <p class="text-right">
                      <button :disabled="tabs === 2" class="btn-outline-success py-1">
                        <span v-if="tabs !== 2">Submit</span>
                        <span v-else>
                          Sending... <i class="fa fa-circle-notch fa-spin"></i>
                        </span>
                      </button>
                    </p>
                  </div>
                </form>
                  <p class="py-4 px-2 text-grey-500">
                    Your account is created {{ $user->created_at->diffForHumans() }}
                    <br>
                    And your account last updated {{ $user->updated_at->diffForHumans() }}
                  </p>
              </div>
              <div class="w-1/4 relative">
                <button @click="$refs.openFileDialog.click()" :disabled="showLoading" class="avatar-edit-btn z-40">
                  <i v-if="!showLoading" class="fa fa-pen"></i>
                  <i v-else class="fa fa-circle-notch fa-spin"></i>
                </button>
                <input @change="saveAvatar($event)" class="hidden" ref="openFileDialog" type="file" accept=".jpg,.jpeg,.png,.svg,.gif" name="image">
                <img :class="showLoading && 'opacity-50'" :src="previewImageUrl || '{{ $user->getImage() }}'" class="rounded-full shadow border-2 border-gray-400 h-40 w-40" alt="{{ auth()->user()->name }}">
              </div>
            </div>
          </div>
          {{-- end col two --}}
        </div>
        {{-- end row --}}
      </div>
      <!-- End main container -->
@endsection
