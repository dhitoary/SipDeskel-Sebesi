<dialog id="login-modal" class="modal">
    <form id="login-form" method="dialog" class="modal-box">
        <h3 class="font-bold text-lg mb-4">Login</h3>
        <input type="text" id="username" name="username" placeholder="Username" class="input input-bordered w-full mb-4" required />
        <input type="password" id="password" name="password" placeholder="Password" class="input input-bordered w-full mb-4" required />
        <div class="modal-action">
            <button type="submit" class="btn btn-primary">Login</button>
            <button type="button" id="cancel-login" class="btn btn-secondary">Cancel</button>
        </div>
        <p id="login-error" class="text-red-600 mt-2 hidden"></p>
    </form>
</dialog>