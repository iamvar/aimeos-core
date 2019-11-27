--
-- PostgreSQL specific database definitions
--

CREATE INDEX "idx_msordprat_si_cd_va" ON "mshop_order_product_attr" ("siteid", "code", left("value", 16));

CREATE INDEX "idx_msordseat_si_cd_va" ON "mshop_order_service_attr" ("siteid", "code", left("value", 16));
