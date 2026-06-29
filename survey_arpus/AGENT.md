# AGENT Rules for survey_arpus

## Development & Maintenance Workflow

### 1. Local Development Cycle
- After every code update on localhost, **must test on localhost first**
- Verify all functionality works before proceeding

### 2. GitHub Deployment
- If localhost tests pass → **commit and push to GitHub**
- Use descriptive commit messages

### 3. Automated GitHub Testing
- After push, **automatically run tests on GitHub** (CI/CD)
- Failed tests must be:
  - Analyzed for root cause
  - Fixed
  - Re-tested until passing

### 4. Cross-Component Synchronization Analysis
Before any deployment, verify alignment across all layers for **all user roles**:

| Layer | Check Points |
|-------|-------------|
| **Backend** | API endpoints, business logic, data validation, auth/authorization per role |
| **Frontend** | UI components, state management, API integration, role-based rendering |
| **Database** | Schema consistency, migrations, constraints, indexes, seed data |
| **System Logic** | Workflows, state transitions, business rules, edge cases |
| **UI/UX** | Design system compliance, accessibility, responsive behavior, role-specific flows |

### 5. Role-Based Verification
Test each module/feature for **all user roles**:
- Admin
- Survey Creator/Manager
- Respondent/Participant
- (Add other roles as defined)

### 6. Pre-Commit Checklist
- [ ] Localhost tests pass
- [ ] No console errors
- [ ] Database migrations work
- [ ] All user role flows tested
- [ ] UI/UX consistent across roles
- [ ] Backend-frontend contract matches
- [ ] No hardcoded localhost URLs

### 7. Post-Deploy Verification
- [ ] GitHub Actions/CI passes
- [ ] Production-like environment test
- [ ] Smoke test critical paths
- [ ] Monitor error logs