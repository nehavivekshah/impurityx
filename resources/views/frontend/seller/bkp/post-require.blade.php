<?php include('header.php');?>
<body>
    <div class="signup-section pt-40 pb-40">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-10 col-lg-10 col-md-12">
                    <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="form-title">
                            <h3>POST RFQ REQUIREMENT</h3>
                        </div>
                        <form class="w-100" id="rfqForm">
                            <div class="row gy-3">
                                <!-- Request ID -->
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label for="requestID" class="form-label-small">Request ID *</label>
                                        <input type="text" placeholder="Request ID" id="requestID" value="Auto"
                                            name="requestID" required class="form-input-small">
                                    </div>
                                </div>
                                <!-- CAS Number -->
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label for="casNumber" class="form-label-small">CAS Number *</label>
                                        <input type="text" placeholder="(Only numerics and hyphens allowed)" required
                                            id="casNumber" name="casNumber" class="form-input-small">
                                    </div>
                                </div>
                                <!-- Impurity Name -->
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label for="impurityName" class="form-label-small">Impurity Name *</label>
                                        <input type="text" placeholder="Impurity Name" required id="impurityName"
                                            name="impurityName" class="form-input-small">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label for="synonynName" class="form-label-small">Synonym Name *</label>
                                        <input type="text" placeholder="Synonym Name" required id="synonynName"
                                            name="synonynName" class="form-input-small">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label for="impuritytype" class="form-label-small">Impurity Type *</label>
                                        <select id="impuritytype" name="impuritytype" class="form-control form-input-small">
                                            <option value="process">Process</option>
                                            <option value="degradation">Degradation</option>
                                            <option value="genotoxic">Genotoxic</option>
                                            <option value="unknown">Unknown</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Impurity Description -->
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label for="impurityDescription" class="form-label-small">Impurity Description :</label>
                                        <textarea class="form-control form-input-small"
                                            placeholder="Impurity Description" id="impurityDescription"
                                            name="impurityDescription" style="height: 80px;"></textarea>
                                    </div>
                                </div>
                                <!-- Quantity -->
                                <div class="col-md-3">
                                    <div class="form-inner">
                                        <label for="quantity" class="form-label-small">Quantity :</label>
                                        <input type="number" class="form-control form-input-small" id="quantity"
                                            name="quantity" placeholder="Quantity">
                                    </div>
                                </div>
                                <!-- UOM -->
                                <div class="col-md-3">
                                    <div class="form-inner">
                                        <label for="uom" class="form-label-small">UOM :</label>
                                        <select id="uom" name="uom" class="form-control form-input-small">
                                            <option value="mg">mg</option>
                                            <option value="gm">gm</option>
                                            <option value="kg">kg</option>
                                            <option value="L">L</option>
                                            <option value="mL">mL</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-inner">
                                        <label for="purity" class="form-label-small">Purity % :</label>
                                        <input type="number" class="form-control form-input-small" id="purity"
                                            name="purity" placeholder="Purity" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-inner">
                                        <label for="potency" class="form-label-small">Potency :</label>
                                        <input type="number" class="form-control form-input-small" id="potency"
                                            name="potency" placeholder="Potency" step="0.01">
                                    </div>
                                </div>
                                <!-- Delivery Time -->
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label for="deliveryTime" class="form-label-small">Delivery Time (days)
                                            :</label>
                                        <input type="number" class="form-control form-input-small" id="deliveryTime"
                                            name="deliveryTime" placeholder="Delivery Time">
                                    </div>
                                </div>
                                <!-- Required Certification -->
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label for="certification" class="form-label-small">Required Certification
                                            :</label>
                                        <input type="text" class="form-control form-input-small" id="certification"
                                            name="certification" placeholder="Required Certification">
                                    </div>
                                </div>
                                <!-- Other Supporting Documents -->
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label for="supportingDocuments" class="form-label-small">Other Supporting
                                            Documents :</label>
                                        <textarea class="form-control form-input-small"
                                            placeholder="Other Supporting Documents" id="supportingDocuments"
                                            name="supportingDocuments" style="height: 80px;"></textarea>
                                    </div>
                                </div>
                                <!-- Attachments -->
                                <div class="col-md-12">
                                    <label class="form-label form-label-small">Attachments :</label>
                                    <div class="row gy-2">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                        <div class="col-md-6">
                                            <div class="input-group attachment-input-group">
                                                <label class="input-group-text attachment-label"
                                                    for="attachment<?php echo $i; ?>">Attachment
                                                    (<?php echo $i; ?>)</label>
                                                <input type="file" class="form-control attachment-input"
                                                    id="attachment<?php echo $i; ?>" name="attachment<?php echo $i; ?>">
                                                <button class="btn btn-outline-secondary delete-attachment"
                                                    type="button" id="deleteAttachment<?php echo $i; ?>"
                                                    style="display:none;" title="Remove Attachment">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <div id="file-name-display<?php echo $i; ?>" class="file-name-display">
                                            </div>
                                        </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit"
                                        class="btn btn-primary account-btn form-input-small">SUBMIT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.php');?>