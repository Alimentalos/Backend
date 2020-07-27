<style>
    .bg-wall{
        width: 100%;
        height: 300px;
        background: #43C6AC;  /* fallback for old browsers */
        background: -webkitlinear-gradient(to right, rgba(25, 22, 84, 0.61), rgba(67, 198, 172, 0.6)), url(../img/background.jpg) no-repeat center center fixed;
        background: linear-gradient(to right, rgba(25, 22, 84, 0.61), rgba(67, 198, 172, 0.6)), url(../img/background.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
</style>
<div class="bg-wall">
    @include('components.navbar')
    <div class="flex flex-col justify-center py-8">
        <div class="text-center mt-5 pt-5">
            <h1 class="text-white font-normal text-4xl">Create Pets</h1>
            <p class="text-white font-light px-8">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid assumenda harum ipsum laudantium minima.</p>
        </div>
    </div>
    @include('components.footer')
</div>
