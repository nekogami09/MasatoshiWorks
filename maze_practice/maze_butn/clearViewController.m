//
//  clearViewController.m
//  maze_butn
//
//  Created by g-2015 on 2013/08/20.
//  Copyright (c) 2013年 g-2015. All rights reserved.
//

#import "clearViewController.h"
//@synthesize clearRemainingTime = _clearRemainingTime;

@interface clearViewController ()

@end

@implementation clearViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    
    self.clearRemainingTimeView.text = [NSString stringWithFormat:@"%d", _clearRemainingTime];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
