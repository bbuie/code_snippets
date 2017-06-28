## Buink Change Log

**Current Release**

[v1.0.0](link_to_tag)

**Step To Create Release (release model)**

1. Create a release branch off `develop` (e.g. `release1.0.0`)
1. Bump the release number in [/README.md](../README.md)
1. Bump the release number in this file and add notes
  - Notes should include a list of all issue numbers and links to those issues
1. Tag the release number (e.g. `git tag v1.0.0` and `git push origin --tags`)
1. Create pull request into master
1. Create pull request for back into develop
1. Deploy master branch after merge


**Step To Create Release (continuous deployment)**

1. Open terminal on your local machine
1. Checkout and update the master branch (e.g 'git checkout master; git pull origin master;)
1. Create a release branch off `master` (e.g. `git checkout -b release1.0.0`)
1. Bump the release number in this file and add notes
  - Notes should include a list of all issue numbers and links to those issues
1. Backup the database to the release branch (if migration is needed)
  - Make sure to test the full build to make sure the new database didn't break the local environment
1. Commit all release changes
1. Push the release branch to the origin (e.g. `git push origin release1.0.0`)
1. Create pull requests for all changes going to be released and merge them
1. Create a pull request for release branch into develop and master
1. Merge release branch back into master
1. Tag the release number (e.g. `git tag v1.0.0` and `git push origin --tags`)
1. Deploy the release branch
1. Alter the involved parties of the release on the issue
1. Move/label the issue appropriately

**Release History**

### [v1.0.0](link_to_tag)

Branch: [release1.0.0](link_to_release_branch), Tag: [v1.0.0](link_to_tag)

- Issue: [#_issue_number](link_to_issue), [pull request](link_to_pull_request)
