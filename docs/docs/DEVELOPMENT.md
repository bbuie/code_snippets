### Setup Your Local Development Enviornment

1. Use our [Docker Setup Steps](../docker/README.md) to run this repository locally

### Branching model (release model)

1. We use the branching model found here: http://nvie.com/posts/a-successful-git-branching-model/
1. Always branch new features off the `develop` branch (`git checkout -b [featureBranchName]`)
    - featureBranchName should start with the issue number and be as short as possible (e.g. 999-example-name)
    - Important: each ticket number should only have one branch and all related changes should be kept on it
    - Important: it is helpful to make a note of the branch name on the issue/card/ticket
1. Commit your changes to the feature branch using the ticket number (e.g. `#999 - added some stuff for new feature`)
    - Always include the issue number at the beginning of the commit message (`git commit -m '#999 - added some stuff for new feature'`)
    - Before you commit your changes, please run a `git diff` to make sure that the changes you're comitting are in fact the changes you want to commit.
1. Ensure that your branch has no linting errors
1. Push your changes to this repo
1. Create a **pull request** from your feature branch to the `develop` branch
    - The title of the pull request is important
        - The title of your pull request should include the issue number and the branch you're merging into (e.g. "999 to develop")
        - You may also want to include a short description of the issue (e.g. "999 to develop | insert_short_description_of_999")
    - Include a link to the original card/ticket/issue
    - Include a GIF of your changes if they affect what a users sees in a browser
        - Try to capture the user story of the issue in the GIF
        - If the user story is difficult to capture in just one GIF, then make two
        - Use [licecap](http://www.cockos.com/licecap/) if you need a good GIF software.
    - Provide a summary of the work you completed in the description of the pull request
1. If there are merge conflicts fix them
    - IMPORTANT: Merge conflicts must result in a conversation with the developer who wrote the conflicting code
1. Review the "diff" of your code
    - Make sure all changes are needed and wanted
    - Comment to explain any unusual code
        - Particularly code that has been removed
    - Clean up code
1. Add "Steps to QA" to the original issue/card/ticket so the reviewer can quickly know what changed and why
    - Some issues already have these
    - These are only required if the changes are difficult or counterintuitive to test
1. Add "Steps to go live" to the original issue/card/ticket if going live requires running a migration or other steps not easily apparent
1. Request a review from the developer lead

### Step To Create Release (release model)

1. Create a release branch off `develop` (e.g. `release1.0.0`)
1. Bump the release number in [/README.md](../README.md)
1. Bump the release number in this file and add notes
    - Notes should include a list of all issue numbers and links to those issues
1. Tag the release number (e.g. `git tag v1.0.0` and `git push origin --tags`)
1. Create pull request into master
1. Create pull request for back into develop
1. Deploy master branch after merge

### Branching model (continuous deployment)

1. Always branch new features off the `master` branch (`git checkout -b [featureBranchName]`)
    - featureBranchName should start with the issue number and be as short as possible (e.g. 999-example-name)
    - Important: each ticket number should only have one branch and all related changes should be kept on it
    - Important: it is helpful to make a note of the branch name on the issue/card/ticket
1. Commit your changes to the feature branch using the ticket number (e.g. `#999 - added some stuff for new feature`)
    - Always include the issue number at the beginning of the commit message (`git commit -m '#999 - added some stuff for new feature'`)
    - Before you commit your changes, please run a `git diff` to make sure that the changes you're comitting are in fact the changes you want to commit.
1. Ensure that your branch has no linting errors
1. Create a **pull request** from your feature branch to the `develop` branch
    - The title of the pull request is important
        - The title of your pull request should include the issue number and the branch you're merging into (e.g. "999 to develop")
        - You may also want to include a short description of the issue (e.g. "999 to develop | insert_short_description_of_999")
    - Include a link to the original card/ticket/issue
    - Include a GIF of your changes if they affect what a users sees in a browser
        - Try to capture the user story of the issue in the GIF
        - If the user story is difficult to capture in just one GIF, then make two
        - Use [licecap](http://www.cockos.com/licecap/) if you need a good GIF software.
    - Provide a summary of the work you completed in the description of the pull request
1. If there are merge conflicts...
    1. Make your code dependent on the third party branch that is conflicting
        - Find the lines of code that are conflicting
            - The easiest way to do this is to TEMPORARILY merge the develop branch, check for conflicting lines, and then ABORT the merge (e.g. `git checkout develop; git pull origin develop; git checkout 999-example-name; git merge develop; git diff --check; git merge --abort`)
            - IMPORTANT: you should make sure you abort the merge otherwise merging the develop branch will cause big issues in the future
        - Use the blame feature of GIT to find both who's code yours is conflicting with and which branch it is related to
        - Then, you need to merge that branch into your branch and resolve the conflict
        - IMPORTANT: make sure to note on the pull request that a conflict was resolved
        - IMPORTANT: it is very easy to make mistakes when resolving conflicts. Common mistakes include code being accidentally removed that was important or code that should have been removed being added back. For this reason, you should always talk to the developer who wrote the conflicting code.
    1. In rare cases where it is not possible to determine who's branch caused the conflict
        - create a branch with a DEV prefix off develop (e.g. `git checkout develop; git checkout -b DEV-999-example-name`)
        - merge in your feature branch to your DEV branch (e.g. `git checkout DEV-999-example-name; git merge 999-example-name`)
        - IMPORTANT: All branches that are based on the develop branch, or have develop merged in, need a DEV prefix in their name!!
    1. In all cases, merge conflicts must result in a conversation with the developer who wrote the conflicting code
1. Review the "diff" of your code
    - Both popular repository websites (Github & Bitbucket) provide the ability to review and comment on your code changes
    - Make sure all changes are needed and wanted
    - Comment to explain any unusual code
        - Particularly code that has been removed
    - Clean up code
1. Add "Steps to QA" to the original issue/card/ticket so the reviewer can quickly know what changed and why
    - Some issues already have these
    - These are only required if the changes are difficult or counterintuitive to test
1. Add "Steps to go live" to the original issue/card/ticket if going live requires running a migration or other steps not easily apparent
1. Request a review from the developer lead

### Step To Create Release (continuous deployment)

1. Open terminal on your local machine
1. Checkout and update the master branch (e.g 'git checkout master; git pull origin master;)
1. Create a release branch off `master` (e.g. `git checkout -b release1.0.0`)
1. Bump the release number in the changelog and add notes
    - Notes should include a list of all issue numbers and links to those issues
1. Backup the database to the release branch (if migration is needed)
    - Make sure to test the full build to make sure the new database didn't break the local environment
1. Commit all release changes
1. Push the release branch to the origin (e.g. `git push origin release1.0.0`)
1. Create pull requests for all changes going to be released and merge them
1. Create a pull request for release branch into develop and master
1. Merge release branch back into master
1. Tag the release number (e.g. `git tag v1.0.0` and `git push origin --tags`)
1. Deploy the master branch
1. Alter the involved parties of the release on the issue
1. Move/label the issue appropriately

###Code style guide

It is important that you write your code in a cost effective way that makes it easy to understand, update, and maintain. The following are some principles you should keep in mind:

- Here are [general code requirements](https://github.com/bbuie/code_snipits/wiki/Common-Code-Requirements).
- Angular code should follow [this angular style guide](https://github.com/johnpapa/angular-styleguide)