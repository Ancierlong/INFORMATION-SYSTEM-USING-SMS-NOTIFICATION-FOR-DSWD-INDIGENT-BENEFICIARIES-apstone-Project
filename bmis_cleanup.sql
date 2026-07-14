TRUNCATE TABLE beneficiaries;
TRUNCATE TABLE beneficiary_family_members;
TRUNCATE TABLE family_role_ref;
TRUNCATE TABLE history_log;
TRUNCATE TABLE notifications;
TRUNCATE TABLE users;

INSERT INTO `users` (`id`, `name`, `email`, `contact_no`, `password`, `role`, `birthday`, `gender`, `created_by`, `image_file_name`, `approval_status`, `approved_date`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@test.com', '01231312312', '$2y$10$Gp8Fol1UN1CRvPO55nOkOubxeMEY3ewgd8e9R7kS2177uDmLkexzq', 1, '1991-01-01', 1, NULL, NULL, 1, NULL, NULL, '2022-11-30 17:02:21', '2023-09-23 03:14:57'),
(2, 'Staff Dela Cruz', 'staff@perpetual.edu.ph', '09123718237', '$2y$10$UvYTT0VhlfD3i0hWel88P.i6dwc8HEQt2.fsjmvRF449x.83rK/.a', 2, '1996-01-01', 1, NULL, NULL, 1, NULL, NULL, '2023-04-09 16:57:40', '2023-07-24 19:41:11'),
(3, 'Staff Two Dela Cruz', 'staffTwo@perpetual.edu.ph', '01231231231', '$2y$10$0mgDVimPfM8XiqevnXhTEujOtCcvQB29eOQzNQ1D/xcaLPZa0aCF2', 2, '1996-01-01', 1, NULL, NULL, 1, NULL, NULL, '2023-06-07 21:15:14', '2023-10-18 20:14:50');
