<?php $__env->startSection('title','Login - Impurity X'); ?>

<?php if(Auth::check()){ Auth::logout(); } ?>

<?php $__env->startSection('headlink'); ?>
<link href="<?php echo e(asset('/assets/backend/css/app.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                <div class="card login-card animated-card">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="card-title">Welcome Back!</h4>
                            <p class="card-subtitle text-muted">Login to continue to Impurity X</p>
                        </div>

                        <form action="/admin/login" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <div class="input-group <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <img src="<?php echo e(asset('/assets/backend/icons/email.svg')); ?>" class="input-icon" alt="Email Icon" />
                                    
                                    <input type="email" name="login_email" class="form-control" placeholder="Email Address" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus />
                                </div>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group">
                                <div class="input-group <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <img src="<?php echo e(asset('/assets/backend/icons/lock.svg')); ?>" class="input-icon" alt="Password Icon" />
                                    <input type="password" name="login_password" class="form-control" placeholder="Password" required autocomplete="current-password" />
                                </div>
                                 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="login_remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                                <?php if(Route::has('password.request')): ?>
                                    <a class="small-link" href="<?php echo e(route('password.request')); ?>">
                                        Forgot Password?
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-block w-100">Login</button>
                            </div>

                            <!--<div class="form-group text-center mt-4 mb-0">
                                <span class="text-muted">Don't have an account?</span>
                                <a class="font-weight-bold" href="<?php echo e(route('register')); ?>">Sign Up</a>
                            </div>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/backend/login.blade.php ENDPATH**/ ?>