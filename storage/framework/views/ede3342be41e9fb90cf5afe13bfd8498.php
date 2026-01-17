<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $__env->yieldContent('title', 'Customer Relationship Management'); ?></title>

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="https://impurityx.com/assets/frontend/images/favicon.jpeg" sizes="180x180">
        <link rel="icon" href="https://impurityx.com/assets/frontend/images/favicon.jpeg" sizes="32x32" type="image/png">
        <link rel="icon" href="https://impurityx.com/assets/frontend/images/favicon.jpeg" sizes="16x16" type="image/png">
        <link rel="icon" href="https://impurityx.com/assets/frontend/images/favicon.jpeg">

        <!--Bootstrap 5 library-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" rel="stylesheet" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <?php echo $__env->yieldContent('headlink'); ?>
        
    </head>
    <body class="bg-light app-body">
        <?php if(Auth::check()): ?>
            <?php echo $__env->make('backend.inc.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
        
        <?php if(Session::has('success')): ?>
            <div class="response-msg">
                <div class="alert alert-success shadow" role="alert">
                    <?php echo e(Session::get('success')); ?>

                </div>
            </div>
        <?php elseif(Session::has('error')): ?>
            <div class="response-msg">
                <div class="alert alert-danger shadow" role="alert">
                    <?php echo e(Session::get('error')); ?>

                </div>
            </div>
        <?php endif; ?>
        
        <?php if($errors->any()): ?>
        <div class="response-msg">
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>

        
        <!--<?php if(session('error')): ?>
        <div class="response-msg">
            <div class="alert alert-danger" role="alert">
                <?php echo e(session('error')); ?>

            </div>
        </div>
        <?php endif; ?>
        
        <?php if(session('status')): ?>
        <div class="response-msg">
            <div class="alert alert-success" role="alert">
                <?php echo e(session('status')); ?>

            </div>
        </div>
        <?php endif; ?>-->
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    
    <?php echo $__env->yieldContent('footlink'); ?>
    
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
</html><?php /**PATH /home/u321815713/domains/impurityx.com/public_html/resources/views/backend/layout.blade.php ENDPATH**/ ?>